<?php 

     use Joomla\CMS\Factory;
     use Joomla\CMS\Language\Text;

     /**
      * @package     Joomla.Site
      * @subpackage  com_emailusers
      *
      * @copyright   Copyright (C) 2022 Ayiana Mallory. All rights reserved.
      * @license     GNU General Public License version 3; see LICENSE
      */

     // No direct access to this file
     defined('_JEXEC') or die( 'Restricted access' );
     
     $weekStart = date_create()->modify('Monday this week')->format('Y-m-d');
     //Trying to pull from the 'reports' table
     $db = JFactory::getDbo();
     $query = $db->getQuery(true);
     $query->select(array('data', 'id'))->from('reports')->where("weekStart = '$weekStart'");
     $db->setQuery($query);
     $weekReports = $db->loadRowList();

	 // Get all student ids (Group 11)
	$group_id = 11;
     $access = new JAccess();
     $allStudentsIDs = $access->getUsersByGroup($group_id);

	$reportStudentIDs = [];
     $numStudentReports = [];
     foreach ($weekReports as $report) {
     array_push($reportStudentIDs, $report[1]);

     $data = json_decode($report[0], true);
     $numReports = count($data) / 4;
     array_push($numStudentReports, $numReports);
     }

     // Deduce the students who did not send reports this week
     $noReportStudentIDs = array_diff($allStudentsIDs, $reportStudentIDs);

     $rows = '';
     foreach ($noReportStudentIDs as $id)
     {
          $user = Factory::getUser($id);
          $rows .= '<tr>';
          $rows .= '<td>' . $user->name . '</td>';
          $rows .= '<td>' . $user->get('email') . '</td>';
          $rows .= '</tr>';
     }
     //no names showing in the table

     if(isset($_POST['button_pressed']))
     {
          $content = 'This email is from the UCF Programming Team. This is a reminder to send in you weekly report.';
          foreach ($noReportStudentIDs as $noReportStudentID) 
          {
               $user = Factory::getUser($noReportStudentID);
               $to = $user->get('email');
               $schedule->call(function () {
                    mail($to, 'UCF Programming Team Report', $content);
               })->cron('00 12 * * sat');
          }
          echo 'Email Sent.';
     }
     //scheduled for every Saturday at 12:00:00
     //$schedule->call(sendEmails())->cron('00 12 * * sat');
?>

<style>
    .section {
        margin-bottom: 20px;
        padding: 10px;
    }
</style>

<div class="displayStudents">
     <h2>Students who have not submit a report this week</h2>
     <h4>Reminder emails are sent automatically each Saturday</h4>
</div>
<table class="table">
     <tr>
          <th>Name</th>
          <th>Email</th>
     </tr>
     <?php echo $rows; ?>
</table>
<form action="" method="post">
    <input class="btn btn-primary" type="submit" value="Send out emails about reports" />
    <input type="hidden" name="button_pressed" value="1" />
</form>
