<?php

namespace news\forms\manage\posts\post;


use news\entities\posts\News;
use news\entities\posts\rubric\Rubrics;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class RubricsForm
 * @package news\forms\manage\posts\post
 *
 * @property array $rubrics
 */
class RubricsForm extends Model
{
    public $rubrics;

    public function __construct(News $news = null, array $config = [])
    {
        if ($news) {
            $this->rubrics = ArrayHelper::getColumn($news->rubricAssignments, 'rubric_id');
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['rubrics', 'required'],
            ['rubrics', 'each', 'rule' => ['integer']]
        ];
    }

    public function rubricsList(bool $news = false): array
    {
        $query = Rubrics::find()->active()->orderBy(['sort' => SORT_ASC]);

        if (!$news) {
            $query->andWhere(['<>', 'slug', 'novosti']);
        }

        return ArrayHelper::map($query->asArray()->all(), 'id', 'name');
    }

    public function beforeValidate(): bool
    {
        $this->rubrics = array_filter((array)$this->rubrics);
        return parent::beforeValidate();
    }

    public function attributeLabels(): array
    {
        return [
            'rubrics' => \Yii::t('app', 'Rubrics'),
        ];
    }
}