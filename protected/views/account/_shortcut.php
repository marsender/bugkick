<div class="shortcut-container" style="display:none;" id="shortcuts">
    <div class="shortcut-header">
        <span><?php echo Yii::t('main', 'Keyboard shortcuts') ?></span> <a class="shortcut-close-link" onclick="$('#shortcuts').css('display', 'none');" href="#"><?php echo Yii::t('main', 'Close') ?></a>
    </div>
    <div class="shortcut-top">
        <?php echo Yii::t('main', 'Keyboard shortcuts are') ?>
        <?php
          if (User::checkHotkeyPreference())
              echo Yii::t('main', 'enabled') .'. <a href="'.$this->createUrl('/settings/shortcutsState').'">'.  Yii::t('main', 'Disable') .'</a>';
          else
              echo Yii::t('main', 'disabled') .'. <a href="'.$this->createUrl('/settings/shortcutsState').'">'.  Yii::t('main', 'Enable') .'</a>';
        ?>
    </div>
<?php
	// Associated javascript
	//   /opt/dev/php/tools/bugkick/js/app-hotkeys.js
	//   /opt/dev/php/tools/bugkick/js/ticket-hotkeys.js
?>
    <div class="shortcut-body">
        <table>
                <td>
                    <table>
                        <tr>
                            <td class="short-key">
                            </td>
                            <td>
                                <h4><?php echo Yii::t('main', 'On all pages') ?>:</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                n
                            </td>
                            <td>
                                : <?php echo Yii::t('main', 'Create new ticket') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                b
                            </td>
                            <td>
                               : <?php echo Yii::t('main', 'Go to tickets page') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                t
                            </td>
                            <td>
                               : <?php echo Yii::t('main', 'Go to summary tickets page') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                p
                            </td>
                            <td>
                               : <?php echo Yii::t('main', 'Go to projects page') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                d
                            </td>
                            <td>
                                : <?php echo Yii::t('main', 'Go to dashboard page') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                u
                            </td>
                            <td>
                                : <?php echo Yii::t('main', 'Go to updates page') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                s
                            </td>
                            <td>
                                : <?php echo Yii::t('main', 'Go to settings page') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                h
                            </td>
                            <td>
                                  : <?php echo Yii::t('main', 'Open shortcuts help') ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                       <tr>
                            <td  class="short-key">
                            </td>
                            <td>
                               <h4><?php echo Yii::t('main', 'On the view ticket page') ?>:</h4>
                            </td>
                        </tr>
                        <tr>
                            <td  class="short-key">
                                e
                            </td>
                            <td>
                                : <?php echo Yii::t('main', 'Edit ticket') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                c
                            </td>
                            <td>
                                : <?php echo Yii::t('main', 'Close ticket') ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="short-key">
                                x
                            </td>
                            <td>
                                 : <?php echo Yii::t('main', 'Delete ticket') ?>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
    </div>
</div>