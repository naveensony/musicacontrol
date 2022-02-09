<?php $__env->startSection('title'); ?> Invoice  <?php $__env->stopSection(); ?><?php $__env->startSection('link_css'); ?><link rel="stylesheet" href="<?php echo e(asset('css/jquery-confirm.min.css')); ?>"><?php $__env->stopSection(); ?><?php $__env->startSection('custom_css'); ?><style>.link-btn {    background-color: #00aeef;    border-color: #00aeef;    color: #ffffff;    display: block;    font-weight: bold;    margin: 8px 0;    padding: 6px;    text-align: center;}</style><?php $__env->stopSection(); ?><?php $__env->startSection('content'); ?>    <div class="wrapper wrapper-content">		<div class="row onetop">            <div class="col-lg-4">                <div class="ibox float-e-margins">                    <div class="ibox-title">                        <span class="label label-default pull-right"><a href="<?php echo e(url('invoice')); ?>">View All</a></span>                        <h5>Entries the past 6 months </h5>                    </div>                    <div class="ibox-content">                        <h1 class="no-margins"><?php echo e($lesssonRecord_all); ?></h1>                        <small>Total Entries</small>                    </div>                </div>            </div>	<div class="col-lg-4">		<div class="ibox float-e-margins">			<div class="ibox-title">				<span class="label label-default pull-right"><a href="<?php echo e(url('invoice').'?which=2'); ?>">View All</a></span>				<h5>Approved Entries</h5>			</div>			<div class="ibox-content">				<h1 class="no-margins"><?php echo e($lesssonRecord_approved); ?></h1>				<small>Total Entries</small>			</div>		</div>	</div>	 <div class="col-lg-4">		<div class="ibox float-e-margins">			<div class="ibox-title">				<span class="label label-default pull-right"><a href="<?php echo e(url('invoice').'?which=1'); ?>">View All</a></span>				<h5>Awaiting Entries</h5>			</div>			<div class="ibox-content">				<h1 class="no-margins"><?php echo e(($lesssonRecord_all-$lesssonRecord_approved)); ?></h1>				<small>Total Entries</small>			</div>		</div>	</div>	</div>	 <div class="row">        <div class="col-sm-12">			<ul class="strip">			<li><span class="grayBlock">&nbsp;&nbsp;&nbsp;&nbsp;</span>  Entry has been approved and cannot be edited or deleted anymore.</li>			<li><span class="whiteBlock">&nbsp;&nbsp;&nbsp;&nbsp;</span> Entry is awaiting approval and can be modified by you.</li>			</ul>	        <p><i class="fa fa-hand-o-right"></i> All checks and approvals are issued on a monthly schedule. All entries (ordered by most recent entry date first)</p>            </div>        </div>		<div class="row ">            <div class="col-sm-6" style="padding-right: 0px;">			<br>			<?php					$now = time();					$alterId = 123;					$months = Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");						$m = intval(date('m',$now)); $y = intval(date('Y',$now)); $i = 6;					while (--$i>-1) {						if ($i<5) echo "\n";						//if ($mon==$m&&$yr==$y) echo $months[$m-1]." $y";						//else 						if($i!=0){							echo "<span class='label' style='margin-right:0px'><a href='/invoice/{$m}/{$y}'>".							$months[$m-1]." {$y}</a></span> &nbsp;&nbsp;&nbsp;&nbsp;";						}else{							echo "<span class='label' style=''><a href='/invoice/{$m}/{$y}'>".							$months[$m-1]." {$y}</a></span>";						}																															--$m;						if ($m==0) {$m += 12; --$y;}					}				?>			</div>			<div class="col-sm-2" style="padding-left: 0px;">				<a class="link-btn" href="<?php echo e(route('new-submit-entry')); ?>">Submit Entry</a>			</div>        </div>		<?php if($lesssonRecord->isNotEmpty()): ?>			<div class ="row paddingzero">			<div class="col-sm-12">				<div class="ibox float-e-margins">					<div class="ibox-content">						<div class="table-responsive">							<table class="table table-striped">								<thead>									<tr>										<th>Date</th>										<th class="two">Type</th>										<th>Student</th>										<th class="four1">Instr.</th>										<th class="five1">Time</th>										<th class="six1">Rate/Hr</th>										<th class="seven1">Pay</th>										<th >&nbsp;</th>									</tr>								</thead>								<tbody class="personal">									<?php $i=1; $amt=0;?>									<?php $__currentLoopData = $lesssonRecord; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>									<?php																				$lastname = trim($lesson->hasStudentName->lastName);										$name = (!empty($lastname)?($lesson->hasStudentName->packageStudent=='Y'&& $lastname[0]!='-'?'- ':"").$lastname.", ":"</br>").$lesson->hasStudentName->firstName;										if ($lesson->sameDayCancel=='n') $lesson->hasrate->teacherRate = $lesson->hasrate->fl_teacherRate;										//If not approved then calculate the amount										if ($lesson->approveDate !='0000-00-00') {										if ($lesson->amount==0) $lesson->amount = sprintf("%.02f",$lesson->lessonDuration*$lesson->hasrate->teacherRate/60);										}										$amt += $lesson->amount;									?>										<?php if($lesson->approveDate !='0000-00-00'): ?>									<tr style="background-color:#CCCCCC">										<?php else: ?>									<tr style="background-color:#ffffff">										<?php endif; ?>										<td ><?php echo e(date('m-d',strtotime($lesson->lessonDate))); ?></td>										<td class="two">										<?php											if ($lesson->sameDayCancel=='T') continue;												$is_adj = $lesson->hasInsturmentName->instrumentName=='Adjustment'?1:0;												$delon = $is_adj?0:1;												switch ($lesson->sameDayCancel) {													case "Y": echo "St. Same Day Cancel"; break;													case "y": echo "St. Same Day Makeup Cancel"; break;													case "A": echo "Te. Cancel"; $delon = 0; break;													case "a": echo "St. Advance Cancel"; $delon = 0; break;													case "V": echo "Vacation"; break;													case "R": echo "Te. Makeup Lesson Cancel"; $delon = 0; break;													case "r": echo "St. Makeup Advance Cancel"; $delon = 0; break;													case "M": echo "Makeup"; break;													case "n": echo "Introductory"; break;													case "O": echo "Other"; break;													case "1": case "2": case "3": case "4":													echo "Regular+ </br>";													$xt = $lesson->sameDayCancel*15;													echo "$xt makeup <br/>(".($lesson->lessonDuration-$xt)."min base)";													break;													default:													if ($lesson->hasInsturmentName->instrumentName=='Adjustment') echo "Adjustment";													else {														echo "Regular";														 }													break;													}										?>										</td>										<td><a href="<?php echo e(url('/invoice').'/'.$lesson->admissionId); ?>"><?php echo e($name); ?></a> </td>										<td class="four1"><?php echo e($lesson->hasInsturmentName->instrumentName); ?></td>										<td class="five1"><?php echo e($lesson->lessonDuration); ?></td>										<td class="six1" ><?php echo e($lesson->hasrate->teacherRate); ?></td>										<td class="seven1"><?php echo e($lesson->amount); ?></td>										<td>										<?php if($lesson->approveDate !='0000-00-00'): ?>										---										<?php else: ?>										<a href="javascript:confirmDelete('<?php echo e($lesson->lessonId); ?>');" ><i class="fa fa-trash white fa-lg"></i> <span class="nav-label"></span></a></a>											</td>										<?php endif; ?>									</tr> 									<tr >									<td class="eight1" colspan="3" align="center" style="border-top:0px; <?php if($lesson->approveDate !='0000-00-00'): ?>  background-color:#CCCCCC <?php else: ?> background-color:#FFFFFF <?php endif; ?>" >Instr: <?php echo e($lesson->hasInsturmentName->instrumentName); ?>, Time: <?php echo e($lesson->lessonDuration); ?>, Rate: <?php echo e($lesson->hasrate->teacherRate); ?>, Pay: <?php echo e($lesson->amount); ?></td>									<td class="eight1" style="border-top:0px; <?php if($lesson->approveDate !='0000-00-00'): ?>  background-color:#CCCCCC <?php else: ?> background-color:#FFFFFF <?php endif; ?>" ></td>									</tr>											  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>									<tr >									<td class="six1"></td>									<td class="two"></td>									<td class="seven1"></td>									<td class="four1"></td>									<td class="five1"></td>									<td  align="right"><strong>Total Earnings: </strong></td>									<td ><strong><?php echo e($amt); ?></strong></td>									<td class="" style="border-top:0px;" ></td>									</tr>  								</tbody>						  </table>						</div> 					 </div> 				 </div> 			 </div> 		</div>		     		<div class="row">			<div class="col-sm-12">				<div class="alert alert-info">					<p><strong>NOTE:</strong> Amount does not reflect guaranteed earnings. It is based on your submissions and is subject to approval by Musika</p>				</div>            </div>        </div>		<?php else: ?>		</br>			<div class="row">			<div class="col-sm-12">				<div class="alert alert-info">					<p>No Entry found for this month. <a href="<?php echo e(url()->previous()); ?>" class=""><strong> &nbsp;&nbsp; Go back</strong></a></p>				</div>			</div>        </div>		<?php endif; ?>		</div>					 <?php $__env->stopSection(); ?><?php $__env->startSection('custom_js'); ?><script>function confirmDelete(lessonId){	$.confirm({					title: 'Confirm!',					content: "Do you want to delete this lesson?",					    buttons: {						confirm: function () {							var csrf_token = $("input[name=_token]").val();					$.ajax({						url: "<?php echo url('/invoice/deletelesson') ?>",						data: {							lessonId:lessonId,							_token: csrf_token						},						type: 'POST',						dataType: 'json',						success: function(response){							if(response.status=='true')							{								$.alert({ title: 'Alert!', content: 'Lesson deleted successfully!',});								location.reload();							} else {								$.alert({ title: 'Alert!', content:'Apparently, lessonId '+lessonId+' either doesn\'t exist or has already been approved. Please try again',});							}						},						error: function(e){						}					});						},						cancel: function () {						},					}				});}	</script><?php $__env->stopSection(); ?><?php $__env->startSection('scripts'); ?><script src="<?php echo e(asset('js/jquery-confirm.min.js')); ?>"></script><?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\musikateachers\resources\views/invoice.blade.php ENDPATH**/ ?>