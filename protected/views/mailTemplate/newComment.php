<html>
    <body>
    <div style='border: 1px solid silver; margin: 10px; padding: 10px;'>
        <h3><?php echo Yii::t('main', 'The ticket') . ' #' . $comment->bug->number . ' "' . $comment->bug->title . '" ' . Yii::t('main', 'received new comment'); ?>:<br></h3>
       <p><b style="color:#666;"><?php echo Yii::t('main', 'Author'); ?>:</b> <?php echo $comment->user->name ?> <?php echo $comment->user->lname ?></p>
       <p><b style="color:#666;"><?php echo Yii::t('main', 'Message'); ?>:</b> <?php echo $comment->message ?></p>
       <br>
       <p style='border-bottom: 1px solid silver;'>&nbsp;</p>
        <table>
            <tr>
                <td>
                    <a style="display: block; text-decoration: none; color: white; background-color: #1A74B0; margin: 10px; padding: 10px;"
                       href='<?php echo $viewBugUrl; ?>'>
                        <?php echo Yii::t('main', 'View ticket'); ?>
                    </a>
                </td>
                <td style="margin:10px; color:#666; font-size:11px;">
                    <?php echo Yii::t('main', 'To view this ticket, visit this link'); ?>:<br>
                    <?php /*echo CHtml::link(
                        Yii::app()->createAbsoluteUrl('bug/view', array('id'=>$comment->bug->number)),
                        Yii::app()->createAbsoluteUrl('bug/view', array('id'=>$comment->bug->number))
                        );*/
                   ?>
                    <?php echo CHtml::link($viewBugUrl, $viewBugUrl); ?>
                </td>
            </tr>
        </table>
    </div>
    </body>
</html>