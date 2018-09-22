<?php
global $cfg;
$entryTypes = array('M'=>'message', 'R'=>'response', 'N'=>'note');
$user = $entry->getUser() ?: $entry->getStaff();
$name = $user ? $user->getName() : $entry->poster;
$avatar = '';
if ($cfg->isAvatarsEnabled() && $user)
    $avatar = $user->getAvatar();
?>



<div class="thread-entry">
        <div class="cabecera">
          <table>
            <tr>
              <td rowspan="2" width="40px">
                <img src="/assets/img/ic-account-circle-copy.svg">
              </td>
              <td class="username" width="300px"><?php echo $name ?></td>
              <td></td>
            </tr>
            <tr>
              <td class="created" width="300px"><?php echo Format::datetime($entry->created); ?></td>
              <td></td>
            </tr>

          </table>
        </div>
        <div class="mensaje">
            <p><?php echo $entry->getBody()->toHtml(); ?></p><br>
        </div>
</div>
