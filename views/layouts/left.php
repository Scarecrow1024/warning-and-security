<?php 
    if(Yii::$app->user->isGuest){
        $head_img = $directoryAsset.'/img/user3-128x128.jpg';
    }else{
        if(Yii::$app->user->identity->photo){
            $head_img = Yii::$app->user->identity->photo;
        }else{
            $head_img = $directoryAsset.'/img/user3-128x128.jpg';
        }
    }
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $head_img?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu For Sec', 'options' => ['class' => 'header']],
                    [
                        'label' => '任务管理',
                        'icon' => 'fa fa-share-square',
                        'url' => '#',
                        'items' => [
                            //['label' => '攻击行为监控', 'icon' => 'fa fa-delicious', 'url' => ['/task-manage/attack'],],
                            ['label' => '可用性监控', 'icon' => 'fa fa-gg-circle', 'url' => ['/task-manage/available'],],
                        ],
                    ],
                    /*[
                        'label' => '安全扫描',
                        'icon' => 'fa fa-share-square',
                        'url' => '#',
                        'items' => [
                            ['label' => '安全扫描', 'icon' => 'fa fa-shield', 'url' => ['/scan/index'],],
                            ['label' => '目录扫描', 'icon' => 'fa fa-slideshare', 'url' => ['/scan/scan_dir'],],
                        ],
                    ],*/
                    [
                        'label' => '代码监控',
                        'icon' => 'fa fa-share-square',
                        'url' => '#',
                        'items' => [
                            ['label' => 'GitHub', 'icon' => 'fa fa-github-alt', 'url' => ['/search/github'],],
                            //['label' => 'Shodan', 'icon' => 'fa fa-slideshare', 'url' => ['/search/shodan'],],
                        ],
                    ],
                    [
                        'label' => '告警平台',
                        'icon' => 'fa fa-share-square',
                        'url' => '#',
                        'items' => [
                            //['label' => '攻击行为监控', 'icon' => 'fa fa-delicious', 'url' => ['/task-manage/attack'],],
                            ['label' => '告警员管理', 'icon' => 'fa fa-gg-circle', 'url' => '#',
                                'items' => [
                                    ['label' => '告警员列表', 'icon' => 'fa fa-shield', 'url' => ['/warning/user/index'],],
                                    ['label' => '添加告警员', 'icon' => 'fa fa-slideshare', 'url' => ['/warning/user/add'],],
                                ],
                            ],
                            ['label' => '告警组管理', 'icon' => 'fa fa-gg-circle', 'url' => '#',
                                'items' => [
                                    ['label' => '告警组列表', 'icon' => 'fa fa-shield', 'url' => ['/warning/role/index'],],
                                    ['label' => '添加告警组', 'icon' => 'fa fa-slideshare', 'url' => ['/warning/role/add'],],
                                ],
                            ],
                            ['label' => '异常管理', 'icon' => 'fa fa-gg-circle', 'url' => '#',
                                'items' => [
                                    ['label' => '异常列表', 'icon' => 'fa fa-shield', 'url' => ['/warning/event/index'],],
                                    ['label' => '添加异常', 'icon' => 'fa fa-slideshare', 'url' => ['/warning/event/add'],],
                                ],
                            ],
                        ],
                    ],
                    ['label' => '管理员管理', 'icon' => 'fa fa-user-secret', 'url' => ['/admin-users']],
                    ['label' => '报警组管理', 'icon' => 'fa fa-bell', 'url' => ['/group/index']],
                    //['label' => '知识库', 'icon' => 'fa  fa-database', 'url' => ['/think-tank/index']],
                    ['label' => '操作日志', 'icon' => 'fa  fa-file-excel-o', 'url' => ['/admin-log/index']],
                    //['label' => '资产管理', 'icon' => 'fa fa-btc', 'url' => ['/asset/index']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => '设置', 'icon' => 'fa fa-dashboard', 'url' => ['/setting/index']],
                ],
            ]
        ) ?>

    </section>

</aside>
