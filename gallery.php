<?php
/*
foreach($gallery as $data) {
    echo "<img src= '$data->img_path' >";
}*/

use humhub\modules\space\models\Space;
use humhub\modules\space\widgets\AboutPageSidebar;
use humhub\modules\content\widgets\richtext\RichText;
use humhub\modules\user\widgets\Image;
use yii\widgets\ActiveForm;
use yii\base;

 /* @var Space $space
 * @var array $userGroups
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('SpaceModule.base', '<strong>Gallery</strong> the Space') ?>
    </div>
    <div class="panel-body">
            </div>
<div class="row">

<div class="col-md-4">
        <div class="media">
            <div class="media-heading"><p><strong>Upload your images in gallery</strong>
                </p></div>
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'upload')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>
            <div class="media-body">
        </div>
        </div>

        <br/>
</div>
</div>