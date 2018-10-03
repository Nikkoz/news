<?php

use yii\db\Migration;

/**
 * Class m180505_111300_tables
 */
class m180505_111300_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'alias' => $this->string(255)->notNull(),
            'preview_text' => $this->text(),
            'detail_text' => $this->text(),
            'data' => $this->text(),
            'hot_picture' => $this->integer()->null(),
            'rectangle_picture' => $this->integer()->null(),
            'square_picture' => $this->integer()->null(),
            'analytic_picture' => $this->integer()->null(),
            'analytic' => $this->boolean()->defaultValue(0),
            'hot' => $this->boolean()->defaultValue(0),
            'discussing' => $this->boolean()->defaultValue(0),
            'reading' => $this->boolean()->defaultValue(0),
            'choice' => $this->boolean()->defaultValue(0),
            'meta_json' => $this->text(),
            'status' => $this->boolean()->defaultValue(1),
            'sort' => $this->integer()->defaultValue(100),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%pictures}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->string(255)->null(),
            'author' => $this->string(255)->null(),
            'sort' => $this->integer()->defaultValue(100),
        ], $tableOptions);

        $this->createIndex('IDX_news_user_created_by', '{{%news}}', 'created_by');
        $this->addForeignKey('IDX_news_user_created_by', '{{%news}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_news_user_updated_by', '{{%news}}', 'updated_by');
        $this->addForeignKey('IDX_news_user_updated_by', '{{%news}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_news_rectangle_picture', '{{%news}}', 'rectangle_picture');
        $this->addForeignKey('IDX_news_rectangle_picture', '{{%news}}', 'rectangle_picture', '{{%pictures}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_news_hot_picture', '{{%news}}', 'hot_picture');
        $this->addForeignKey('IDX_news_hot_picture', '{{%news}}', 'hot_picture', '{{%pictures}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_news_square_picture', '{{%news}}', 'square_picture');
        $this->addForeignKey('IDX_news_square_picture', '{{%news}}', 'square_picture', '{{%pictures}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_news_analytic_picture', '{{%news}}', 'analytic_picture');
        $this->addForeignKey('IDX_news_analytic_picture', '{{%news}}', 'analytic_picture', '{{%pictures}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%sliders}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%news_slider_assignments}}', [
            'news_id' => $this->integer(),
            'slider_id' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('PK-news_slider_assignments', '{{%news_slider_assignments}}', ['news_id', 'slider_id']);

        $this->createIndex('IDX_ns_news_id', '{{%news_slider_assignments}}', 'news_id');
        $this->addForeignKey('IDX_ns_news_id', '{{%news_slider_assignments}}', 'news_id', '{{%news}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_ns_slider_id', '{{%news_slider_assignments}}', 'slider_id');
        $this->addForeignKey('IDX_ns_slider_id', '{{%news_slider_assignments}}', 'slider_id', '{{%sliders}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%sliders_pictures_assignments}}', [
            'slider_id' => $this->integer(),
            'picture_id' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('PK-sliders_pictures_assignments', '{{%sliders_pictures_assignments}}', ['slider_id', 'picture_id']);

        $this->createIndex('IDX_sp_slider_id', '{{%sliders_pictures_assignments}}', 'slider_id');
        $this->addForeignKey('IDX_sp_slider_id', '{{%sliders_pictures_assignments}}', 'slider_id', '{{%sliders}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_sp_picture_id', '{{%sliders_pictures_assignments}}', 'picture_id');
        $this->addForeignKey('IDX_sp_picture_id', '{{%sliders_pictures_assignments}}', 'picture_id', '{{%pictures}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%videos}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'site' => $this->string(255)->null(),
            'picture_id' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_videos_picture_id', '{{%videos}}', 'picture_id');
        $this->addForeignKey('IDX_videos_picture_id', '{{%videos}}', 'picture_id', '{{%pictures}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%news_videos_assignments}}', [
            'news_id' => $this->integer(),
            'video_id' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('PK-news_videos_assignments', '{{%news_videos_assignments}}', ['news_id', 'video_id']);

        $this->createIndex('IDX_nv_news_id', '{{%news_videos_assignments}}', 'news_id');
        $this->addForeignKey('IDX_nv_news_id', '{{%news_videos_assignments}}', 'news_id', '{{%news}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_nv_video_id', '{{%news_videos_assignments}}', 'video_id');
        $this->addForeignKey('IDX_nv_video_id', '{{%news_videos_assignments}}', 'video_id', '{{%videos}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%rubrics}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'color' => $this->string(255)->null(),
            'meta_json' => $this->text(),
            'sort' => $this->integer()->defaultValue(100),
        ], $tableOptions);

        $this->createTable('{{%news_rubrics_assignments}}', [
            'news_id' => $this->integer(),
            'rubric_id' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('PK-news_rubrics_assignments', '{{%news_rubrics_assignments}}', ['news_id', 'rubric_id']);

        $this->createIndex('IDX_nr_news_id', '{{%news_rubrics_assignments}}', 'news_id');
        $this->addForeignKey('IDX_nr_news_id', '{{%news_rubrics_assignments}}', 'news_id', '{{%news}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_nr_rubric_id', '{{%news_rubrics_assignments}}', 'rubric_id');
        $this->addForeignKey('IDX_nr_rubric_id', '{{%news_rubrics_assignments}}', 'rubric_id', '{{%rubrics}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ], $tableOptions);

        $this->createTable('{{%news_tags_assignments}}', [
            'news_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_nt_news_id', '{{%news_tags_assignments}}', 'news_id');
        $this->addForeignKey('IDX_nt_news_id', '{{%news_tags_assignments}}', 'news_id', '{{%news}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_nt_tag_id', '{{%news_tags_assignments}}', 'tag_id');
        $this->addForeignKey('IDX_nt_tag_id', '{{%news_tags_assignments}}', 'tag_id', '{{%tags}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey('IDX_news_user_created_by', '{{%news}}');
        $this->dropIndex('IDX_news_user_created_by', '{{%news}}');

        $this->dropForeignKey('IDX_news_user_updated_by', '{{%news}}');
        $this->dropIndex('IDX_news_user_updated_by', '{{%news}}');

        $this->dropForeignKey('IDX_news_rectangle_picture', '{{%news}}');
        $this->dropIndex('IDX_news_rectangle_picture', '{{%news}}');

        $this->dropForeignKey('IDX_news_hot_picture', '{{%news}}');
        $this->dropIndex('IDX_news_hot_picture', '{{%news}}');

        $this->dropForeignKey('IDX_news_square_picture', '{{%news}}');
        $this->dropIndex('IDX_news_square_picture', '{{%news}}');

        $this->dropForeignKey('IDX_news_analytic_picture', '{{%news}}');
        $this->dropIndex('IDX_news_analytic_picture', '{{%news}}');

        $this->dropPrimaryKey('PK-news_slider_assignments', '{{%news_slider_assignments}}');

        $this->dropForeignKey('IDX_ns_news_id', '{{%news_slider_assignments}}');
        $this->dropIndex('IDX_ns_news_id', '{{%news_slider_assignments}}');

        $this->dropForeignKey('IDX_ns_slider_id', '{{%news_slider_assignments}}');
        $this->dropIndex('IDX_ns_slider_id', '{{%news_slider_assignments}}');

        $this->dropPrimaryKey('PK-sliders_pictures_assignments', '{{%sliders_pictures_assignments}}');

        $this->dropForeignKey('IDX_sp_slider_id', '{{%sliders_pictures_assignments}}');
        $this->dropIndex('IDX_sp_slider_id', '{{%sliders_pictures_assignments}}');

        $this->dropForeignKey('IDX_sp_picture_id', '{{%sliders_pictures_assignments}}');
        $this->dropIndex('IDX_sp_picture_id', '{{%sliders_pictures_assignments}}');

        $this->dropForeignKey('IDX_videos_picture_id', '{{%videos}}');
        $this->dropIndex('IDX_videos_picture_id', '{{%videos}}');

        $this->dropPrimaryKey('PK-news_videos_assignments', '{{%news_videos_assignments}}');

        $this->dropForeignKey('IDX_nv_news_id', '{{%news_videos_assignments}}');
        $this->dropIndex('IDX_nv_news_id', '{{%news_videos_assignments}}');

        $this->dropForeignKey('IDX_nv_video_id', '{{%news_videos_assignments}}');
        $this->dropIndex('IDX_nv_video_id', '{{%news_videos_assignments}}');

        $this->dropPrimaryKey('PK-news_rubrics_assignments', '{{%news_rubrics_assignments}}');

        $this->dropForeignKey('IDX_nr_news_id', '{{%news_rubrics_assignments}}');
        $this->dropIndex('IDX_nr_news_id', '{{%news_rubrics_assignments}}');

        $this->dropForeignKey('IDX_nr_rubric_id', '{{%news_rubrics_assignments}}');
        $this->dropIndex('IDX_nr_rubric_id', '{{%news_rubrics_assignments}}');

        $this->dropPrimaryKey('PK-news_tags_assignments', '{{%news_tags_assignments}}');

        $this->dropForeignKey('IDX_nt_news_id', '{{%news_tags_assignments}}');
        $this->dropIndex('IDX_nt_news_id', '{{%news_tags_assignments}}');

        $this->dropForeignKey('IDX_nt_tag_id', '{{%news_tags_assignments}}');
        $this->dropIndex('IDX_nt_tag_id', '{{%news_tags_assignments}}');

        $this->dropTable('{{%news}}');

        $this->dropTable('{{%pictures}}');

        $this->dropTable('{{%news_slider_assignments}}');

        $this->dropTable('{{%sliders}}');

        $this->dropTable('{{%sliders_pictures_assignments}}');

        $this->dropTable('{{%videos}}');

        $this->dropTable('{{%news_videos_assignments}}');

        $this->dropTable('{{%rubrics}}');

        $this->dropTable('{{%news_rubrics_assignments}}');

        $this->dropTable('{{%tags}}');

        $this->dropTable('{{%news_tags_assignments}}');
    }
}
