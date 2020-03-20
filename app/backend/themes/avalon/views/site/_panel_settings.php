<?php
use yii\helpers\Url;
use common\models\object\export\dictionary\ObjectExportStatusType;
use common\models\object\dictionary\ObjectSourceTypeDictionary;

$buttons = [];
$action = "";

/** @var \backend\models\panel\BasePanel[] $panel */
foreach ($data as $panel) {
    $url = Url::toRoute(['user/use-panel', 'type' => $panel->getType()]);

    if ($panel->isEnabled(Yii::$app->user)) {
        $object_id = (string)$panel->getType();
        $panel_id = "NOT_".(string)$panel->getType();
        $class = "fa fa-check-square-o";
        $i_style = 'color:green';
    } else {
        $object_id = (string)$panel->getType();
        $panel_id = (string)$panel->getType();
        $class = "fa fa-square-o";
        $i_style = '';

    }

    $buttons[] =  '<li>
        <a class="panel_options_button" role="menuitem" data-ids="'.$object_id.'" data-panel="'.$panel_id.'" tabindex="-1" data-url="'.$url.'"><i class="'.$class.'" style="'.$i_style.'"></i>  '.$panel->getTitle().'</a>
    </li>';
}

?>

<?php if (count($buttons) > 0): ?>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Настройки панели <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <?=implode("", $buttons)?>
            </ul>
        </li>
    </ul>
<?php endif;?>

<?php $this->registerJs('
    $(document).ready(function() {
         $(".panel_options_button").on("click", function() {
             var url = $(this).data("url");
             var ids = $(this).data("ids");
             var panel = $(this).data("panel");
             var form = $("<form action=" + url + " method=\"POST\"></form>"),
                 csrfParam = $("meta[name=csrf-param]").prop("content"),
                 csrfToken = $("meta[name=csrf-token]").prop("content");

             if (csrfParam) {
                 form.append("<input type=\"hidden\" name=" + csrfParam + " value=" + csrfToken + " />");
             }

             form.append("<input type=\"hidden\" name=\"ids[]\" value=" + ids + " />");

             form.append("<input type=\"hidden\" name=\"panel_id\" value=" + panel + " />");
             form.appendTo("body").submit();
             form.submit();
             return false;
         });
    });
');?>
