<?php $__env->startSection('custom_css'); ?>
<style>
.sub-menu {
            display: none;
        }
		.sub-menu li {
			list-style-type: none;
		}
        .sub-menu li a {
            padding: 7px 10px 7px 10px;
            padding-left: 52px;
            color: #a7b1c2;
            font-weight: 600;
            position: relative;
            display: block;
            text-decoration: none;
        }
        .sub-menu li a:hover {
            color: #fff;
        }
	.pro-status{
		background-color: red;
		margin-left: 10px;
		margin-right: 2px;
		padding-left: 3px;
		padding-right: 4px;
	}
</style>	
<?php $__env->stopSection(); ?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element" style="text-align: center;">
                    <a href="<?php echo e(url('/')); ?>">
						<?php if(Auth::check() ): ?>
<?php
	$avatar=App\Models\User::with('teacherId')->where('id',Auth::id())->first();
	$newavt=str_replace("@{{THUMBNAILMASK}}","avatarSize",$avatar->teacherId->avatar);
?>
						<span>
                            <img alt="image" width="116px"  class="img-circle" src="http://ceo.musikalessons.com/uploads/TeachersModel/<?php echo e($avatar->teacherId->id); ?>/avatar/<?php echo e($newavt); ?>">
                            <!--<img alt="image" width="116px"  class="img-circle" src="<?php echo e(url('/public/thumbnail')); ?>/<?php echo e($newavt); ?>">-->
                         </span>
						  <span class="block m-t-xs">
                                <a href="<?php echo e(route('account.index')); ?>"><strong class="font-bold"> <?php if(Auth::check()): ?><?php echo e(Auth::user()->firstName); ?> <?php echo e(Auth::user()->lastName); ?><?php endif; ?></strong></a>
                        </span>
						 <?php else: ?>
						 <span>
                            <img alt="image"  width="116px" height="116px" class="img-circle" src="<?php echo e(url('img\profile.png')); ?>">
                         </span>
						  <span class="block m-t-xs">
                                <a href="<?php echo e(route('account.index')); ?>"><strong class="font-bold"> <?php if(Auth::check()): ?><?php echo e(Auth::user()->firstName); ?> <?php echo e(Auth::user()->lastName); ?><?php endif; ?></strong></a>
                        </span>
						 <?php endif; ?>
                    </a>
                </div>
                <div class="logo-element">
                </div>
            </li>
			
			<li class="<?php echo e(isActiveRoute('account.index')); ?>">
				<a href="<?php echo e(route('account.index')); ?>"><i class="fa fa-pencil"></i> <span class="nav-label">Account</span></a>
			</li>
			<li class="<?php echo e(isActiveRoute('paymentMethod')); ?>">
				<a href="<?php echo e(route('paymentMethod')); ?>"><i class="fa fa-pencil"></i> <span class="nav-label"><font style="color:yellow">New!</font> Payment Method</span></a>
			</li>
			<li class="<?php echo e(isActiveRoute('profile')); ?>">
				<?php if(Auth::check() ): ?>
					<?php
						$user=App\Models\User::with('teacherId')->where('id',Auth::id())->first();
						$completenss=$user->teacherId->profile_completenss;
					?>
				<?php else: ?>
					<?php 
						$completenss = 'Not found';
					?>	
				<?php endif; ?>	
				<a href="<?php echo e(route('profile')); ?>"><i class="fa fa-user-circle-o"></i> <span class="nav-label">Profile</span> <?php if($completenss=='Incomplete'): ?> <span class="pull-right label label-primary" style="background-color: #ff0000;"><?php echo e($completenss); ?>!</span> <?php endif; ?></a>
			</li>
				<?php if(Auth::check() ): ?>
					<?php
						$user=App\Models\User::with('teacherId')->where('id',Auth::id())->first();
						$sku=$user->teacherId->id;
						$cSession = curl_init(); 
						curl_setopt($cSession,CURLOPT_URL,'http://musika.reziew.com/api/1/review/list.json?sku=' . $sku .'&order=desc');
						curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
						curl_setopt($cSession,CURLOPT_HEADER, false); 
						$output=curl_exec($cSession);
						$temp = array( $sku => array( 'average' => 0 , 'count' => 0) );
						$r = json_decode($output,1);
						curl_close($cSession);
					?>
				<?php endif; ?>
			<li class="<?php echo e(isActiveRoute('review')); ?>">
				<a href="<?php echo e(route('review')); ?>"><i class="fa fa-envelope"></i> <span class="nav-label">Reviews </span> <?php if(isset($r['reviews']) && count($r['reviews']) < 4): ?> <span class="pull-right label label-primary" style="background-color: #ff0000;">Low Count!</span> <?php elseif(!isset($r['reviews'])): ?> <span class="pull-right label label-primary" style="background-color: #ff0000;">Low Count!</span> <?php endif; ?></a>
			</li>
			<li class="<?php echo e(isActiveRoute('home')); ?>">
				<?php if(Auth::check() ): ?>
					<?php
						$pros_students=App\Models\Connection::with('prospectiveStudent','instrument','pro_status')->where('teacherid',$user->teacherId->remoteTeacherId)->where('dateInitInformed','0000-00-00 00:00:00')->get();
						$cnt_stu=0;
					?>
					<?php if($pros_students->isNotEmpty()): ?>
						<?php $__currentLoopData = $pros_students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unrstudent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>	
							<?php if(!is_null($unrstudent->prospectiveStudent)): ?>
								<?php $cnt_stu++;  ?>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<?php $cnt_stu=0; ?>	
					<?php endif; ?>		
				<?php endif; ?>	
				<a href="<?php echo e(route('home')); ?>"><i class="fa fa-users"></i> <span class="nav-label">Students </span> </a>
			</li>
			<li class="<?php echo e(isActiveRoute('viewProspective')); ?>">
				<a href="<?php echo e(route('searchProspective')); ?>"><i class="fa fa-search"></i> <span class="nav-label">Available Students</span></a>
			</li>
			<li class="<?php echo e(isActiveRoute('invoice')); ?>">
				<a href="<?php echo e(url('/invoice')); ?>"><i class="fa fa-usd"></i> <span class="nav-label">Invoices</span></a>
			</li>
			<li class="<?php echo e(isActiveRoute('new-submit-entry')); ?>">
				<a href="<?php echo e(route('new-submit-entry')); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">Submit Entry</span></a>
			</li>
			 <li class="<?php echo e(isActiveRoute('trail-lesson')); ?>">
				<a href="<?php echo e(url('/trialLesson')); ?>"><i class="fa fa-bullhorn"></i><span class="nav-label">Trial Lesson Indicator</span></a>
			 </li> 
			 <li class="<?php echo e(isActiveRoute('terminate-student')); ?>" id="is_enable">
				<a href="<?php echo e(('/terminateLessons')); ?>"><i class="fa fa-chain-broken"></i><span class="nav-label">Student Ending Lessons</span></a>
			 </li>
			  <li class="<?php echo e(isActiveRoute('handbook')); ?>">
				<a href="<?php echo e(route('handbook')); ?>"><i class="fa fa-question-circle"></i><span class="nav-label">FAQ</span></a>
			 </li>
			 <li class="<?php echo e((strpos($_SERVER['REQUEST_URI'], 'helpvideo'))?'active':''); ?>">
				<a href="#"><i class="fa fa-file-video-o"></i> <span class="nav-label">Help Videos</span><span class="fa arrow"></span></a>
			 <ul class="sub-menu">
                    <li class="<?php echo e(isActiveRoute('requesting-student')); ?>"><a href="<?php echo e(route('requesting-student')); ?>">Requesting Students</a></li>
                    <li class="<?php echo e(isActiveRoute('intro-lesson')); ?>"><a href="<?php echo e(route('intro-lesson')); ?>">Submitting Intro Lesson</a></li>
                    <li class="<?php echo e(isActiveRoute('change-status')); ?>"><a href="<?php echo e(route('change-status')); ?>">Change Student Status</a></li>
                    <li class="<?php echo e(isActiveRoute('logging-lessons')); ?>"><a href="<?php echo e(route('logging-lessons')); ?>"> Logging Lessons</a></li>
               </ul>
            </li>
			<li class="<?php echo e(isActiveRoute('support')); ?>">
				<a href="<?php echo e(route('support')); ?>" target="_blank"><i class="fa fa-question-circle"></i><span class="nav-label">Support</span></a>
			 </li>
			<li class="<?php echo e(isActiveRoute('studentsList')); ?>">
				<a href="<?php echo e(route('studentsList')); ?>" target="_blank"><i class="fa fa-question-circle"></i><span class="nav-label">Messages</span></a>
			 </li> 
        </ul>
    </div>
</nav>
<?php $__env->startSection('scripts'); ?>
<script>
    $('.sub-menu-trigger').on('click', function () {
        $(this).parents('li').toggleClass('active');
        $(this).next('.sub-menu').slideToggle(250);
    });
</script>
<?php $__env->stopSection(); ?><?php /**PATH C:\xampp\htdocs\musikateachers\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>