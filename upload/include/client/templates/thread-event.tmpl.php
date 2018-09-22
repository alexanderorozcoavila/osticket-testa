<?php
$desc = $event->getDescription(ThreadEvent::MODE_CLIENT);
//print var_dump($event);
if (!$desc)
    return;
?>


<div class="thread-entry">
        <div class="cabecera">
          <table>
            <tr>
              <td rowspan="2" width="40px">
                <img src="/assets/img/ic-account-circle-copy.svg">
              </td>
              <td class="username" width="300px"><?php echo $event->username; ?></td>
              <td></td>
            </tr>
            <tr>
              <td class="created" width="300px"><?php echo $event->user->created; ?></td>
              <td></td>
            </tr>

          </table>
        </div>
        <div class="mensaje">
            <p><?php echo $event->state; ?></p><br>
        </div>
</div>
