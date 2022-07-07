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

     $sendDate = date_create()->modify('Saturday this week')->format('Y-m-d');
     $group_id = 11;
     $access = new JAccess();
     $allStudentIDs = $access->getUsersByGroup($group_id);

     $reportStudentIDs = [];
     foreach ($weekReports as $report)
     {
          array_push($reportStudentIDs, $report[1]);
     }
     $noReportStudentIDs = array_diff($allStudentIDs, $reportStudentIDs);

     $rows = '';
     foreach ($noReportStudentIDs as $id)
     {
          $user = JFactory::getUser($id);
          $rows .= '<tr>';
          $rows .= '<td>' . $user->name . '</td>';
          $rows .= '<td>' . $user->get('email') . '</td>';
          $rows .= '</tr>';
     }

     if(isset($_POST['button_pressed']))
     {
          $content = 'This email is to remind you to send in you weekly report.';
          foreach ($noReportStudentIDs as $id) 
          {
               $user = JFactory::getUser($id);
               $to = $user->get('email');
               mail($to, 'Programming Team Report', $content);
          }

          echo 'Email Sent.';
     }
?>

<style>
    .section {
        margin-bottom: 20px;
        padding: 10px;
    }
</style>

<div class="displayStudents">
     <h2>Students who have not completed this week's report.</h2>
</div>
<table class="table">
     <tr>
     <th>Name</th>
     <th>Email</th>
     </tr>
     <?php echo $rows; ?>
</table>
<form action="" method="post">
    <input type="submit" value="Send out emails about reports" />
    <input type="hidden" name="button_pressed" value="1" />
</form>
