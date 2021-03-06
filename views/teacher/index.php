<?php

use app\models\Teacher;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($this->context->action->id == 'index'): ?>
    <p>
        <?= Html::a('Добавить учителя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'gender',
                'content' => function ($data) {
                    return $data->getGenderName();
                },
                'filter' => Teacher::getGendersList()
            ],
            'phone',
            'students_count',
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>

</div>
