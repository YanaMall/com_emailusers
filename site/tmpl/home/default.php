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
     
     //Trying to pull from the 'reports' table
     $db = JFactory::getDbo();
     $query = $db->getQuery(true);
     $query->select('*');
     $query->from('reports');

     $group_id = 11;
     $access = new JAccess();
     $allStudentIDs = $access->getUsersByGroup($group_id);

     $reportStudentIDs = [];
     foreach ($allStudentIDs as $id)
     {
          //trying to query the id from reports
          if ($query->from('reports')->where("id = '$id'"))
          {
               $user = JFactory::getUser($id);
               array_push($reportStudentIDs, $user);
          }
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

     function sendEmails()
     {
          $img = file_get_contents('download.jpg');
          $imgdata = base64_encode($img);
          $content = 'This email is from the UCF Programming Team. This is a reminder to send in you weekly report. <img src='data:image/x-icon;base64,$imgdata'/>';
          foreach ($noReportStudentIDs as $id) 
          {
               $user = JFactory::getUser($id);
               $to = $user->get('email');
               mail($to, 'UCF Programming Team Report', $content);
          }
          echo 'Email Sent.';
     }

     if(isset($_POST['button_pressed']))
     {
          sendEmails();
     }
     //scheduled for every Saturday at 12:00:00
     schedule->call(sendEmails())->cron('00 12 * * sat');
?>

//Getting the syntax error: unexpected 'data' (T_STRING) 

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
