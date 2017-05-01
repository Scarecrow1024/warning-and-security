<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\models\User;

    $this->title = '';
?>
<?php $form=ActiveForm::begin([
        'method' => 'post',
        'action' => '/search/github'
    ]);?>
<style>
    .code-list .title {
    min-height: 24px;
    margin: -3px 0 10px 38px;
    font-weight: 600;
    line-height: 1.2;
    }
    .code-list .avatar {
        float: left;
    }
    .avatar {
        display: inline-block;
        overflow: hidden;
        line-height: 1;
        vertical-align: middle;
        border-radius: 3px;
    }
    img {
        border-style: none;
    }
    * {
        box-sizing: border-box;
    }
    img[Attributes Style] {
        height: 28px;
        width: 28px;
    }
    p {
        margin-top: 0;
        margin-bottom: 10px;
    }
    * {
        box-sizing: border-box;
    }

    p {
        display: block;
        -webkit-margin-before: 1em;
        -webkit-margin-after: 1em;
        -webkit-margin-start: 0px;
        -webkit-margin-end: 0px;
    }
        .blob-code {
        position: relative;
        padding-right: 10px;
        padding-left: 10px;
        line-height: 20px;
        vertical-align: top;
    }
    .blob-code-inner {
        overflow: visible;
        font-family: Consolas, "Liberation Mono", Menlo, Courier, monospace;
        font-size: 12px;
        color: #333;
        word-wrap: normal;
        white-space: pre;
    }
    .code-list .blob-code {
        white-space: pre-wrap;
    }
    .code-list em {
        padding: 2px;
        margin: 0 -2px;
        font-style: normal;
        font-weight: 600;
        color: #333;
        background-color: rgba(255,255,140,0.5);
        border-radius: 3px;
    }
    a {
        color: #4078c0;
        text-decoration: none;
    }

    a {
        background-color: transparent;
        -webkit-text-decoration-skip: objects;
    }
    * {
        box-sizing: border-box;
    }
    .blob-wrapper {
        overflow-x: auto;
        overflow-y: hidden;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }
    .language {
        float: right;
    }
    * {
        box-sizing: border-box;
    }
    div {
        display: block;
    }
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
    table {
        display: table;
        border-collapse: separate;
        border-spacing: 2px;
        border-color: grey;
    }
    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    .code-list .code-list-item+.code-list-item {
        padding-top: 20px;
        margin-top: 20px;
        margin-bottom: 10px;
        border-top: 1px solid #eee;
    }
</style>
<div class="box box-solid box-default">
    <div class="box-header">
        <div class="input-group col-xs-6 col-md-6 col-md-offset-3 col-center-block">
        <input type="text" name="q" class="form-control" placeholder="Search..." value="<?php echo $q?>">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" onclick="loading()" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </div>
    <div class="box-body">
        <?php echo $res?>
    </div>
</div>
 
<?php ActiveForm::end();?>

<script>
    function loading(){
        var index = layer.load(2);
        layer.msg('loading...', {
          icon: 16,
          time: 2000 
        }, function(){
            index;
        });
    }
</script>