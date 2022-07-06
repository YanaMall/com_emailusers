<?php 

     use Joomla\CMS\Factory;
     use Joomla\CMS\Language\Text;

     /**
      * @package     Joomla.Administrator
      * @subpackage  com_emailusers
      *
      * @copyright   Copyright (C) 2022 Ayiana Mallory. All rights reserved.
      * @license     GNU General Public License version 3; see LICENSE
      */

     // No direct access to this file
     defined('_JEXEC') or die( 'Restricted access' );
?>
<?php
     function debug_to_console($data) 
     {
          $output = $data;
          if (is_array($output))
              $output = implode(',', $output);
          echo "<script>console.log('".$output."');</script>";
     }

      $groupId = 11;
      $access = new JAccess();
      $members = $access->getUsersByGroup($groupId);
      
      $rows = '';
      $users = [];
      foreach ($members as $id) 
      {
          $user = JFactory::getUser($id);
          array_push($users, $user);
          $rows .= '<tr>';
          $rows .= '<td>' . $user->name . '</td>';
          $rows .= '<td>' . $user-> $db->quoteName('email') . '</td>';
          $rows .= '</tr>';
     }

     if(isset($_POST['button_pressed']))
     {
          $content = 'This email is to remind you to send in you weekly report';
          foreach ($members as $id) 
          {
               mail($id, 'Programming Team Report', $content);
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

<div class="section">
    <h2>table of students</h2>
</div>

    <h3>Select a Student</h3>
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