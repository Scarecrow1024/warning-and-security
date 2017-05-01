<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use app\models\User;

    $this->title = '';
?>

<style type="text/css">
   @media (max-width: 979px) and (min-width: 768px)
.row-fluid .span9 {
    width: 74.30939226%;
}

@media (max-width: 979px) and (min-width: 768px)
.row-fluid [class*="span"] {
    display: block;
    width: 100%;
    min-height: 28px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    box-sizing: border-box;
    float: left;
    margin-left: 2.762430939%;
}
.row-fluid .span9 {
    width: 74.468085099%;
}

#search-results .results-count {
    color: #888;
    font-size: 11px;
}

user agent stylesheet
div {
    display: block;
}
Inherited from div.container-fluid

.search-result {
    border-bottom: 1px solid #eee;
    line-height: 12px;
    margin-bottom: 10px;
    text-shadow: none;
}

.search-result {
    font-family: Arial;
}
user agent stylesheet
div {
    display: block;
}
div {
    display: block;
}
Inherited from div.search-result
.search-result {
    border-bottom: 1px solid #eee;
    line-height: 12px;
    margin-bottom: 10px;
    text-shadow: none;
}
.search-result {
    font-family: Arial;
}
Inherited from div.container-fluid
body>.container, body>.container-fluid {
    text-shadow: 1px 1px white;
}

.search-result>.search-result-summary {
    float: left;
    font-weight: bold;
    margin-bottom: 20px;
    width: 250px;
}

user agent stylesheet
div {
    display: block;
}
Inherited from div.search-result
.search-result {
    border-bottom: 1px solid #eee;
    line-height: 12px;
    margin-bottom: 10px;
    text-shadow: none;
}
.search-result {
    font-family: Arial;
}

.search-result .os {
    color: black;
    font-size: 10px;
    font-weight: bold;
}

a {
    color: #c60f13;
    text-decoration: none;
}
user agent stylesheet
a:-webkit-any-link {
    color: -webkit-link;
    text-decoration: underline;
    cursor: auto;
}
Inherited from div.search-result-summary
.search-result>.search-result-summary {
    float: left;
    font-weight: bold;
    margin-bottom: 20px;
    width: 250px;
}

.search-result>div span {
    color: #aaa;
    font-size: 10px;
    font-weight: normal;
}

Inherited from div.search-result-summary
.search-result>.search-result-summary {
    float: left;
    font-weight: bold;
    margin-bottom: 20px;
    width: 250px;
}
Inherited from div.search-result
.search-result {
    border-bottom: 1px solid #eee;
    line-height: 12px;
    margin-bottom: 10px;
    text-shadow: none;
}

img {
    max-width: 100%;
    vertical-align: middle;
    border: 0;
    -ms-interpolation-mode: bicubic;
}

Inherited from div.search-result-summary
.search-result>.search-result-summary {
    float: left;
    font-weight: bold;
    margin-bottom: 20px;
    width: 250px;
}
Inherited from div.search-result
.search-result {
    border-bottom: 1px solid #eee;
    line-height: 12px;
    margin-bottom: 10px;
    text-shadow: none;
}

.search-result a.city {
    color: black;
    font-size: 10px;
    font-weight: normal;
    margin-left: 6px;
    line-height: 18px;
    text-decoration: none;
}

a {
    color: #c60f13;
    text-decoration: none;
}
user agent stylesheet
a:-webkit-any-link {
    color: -webkit-link;
    text-decoration: underline;
    cursor: auto;
}
Inherited from div.search-result-summary
.search-result>.search-result-summary {
    float: left;
    font-weight: bold;
    margin-bottom: 20px;
    width: 250px;
}

.search-result a.city {
    color: black;
    font-size: 10px;
    font-weight: normal;
    margin-left: 6px;
    line-height: 18px;
    text-decoration: none;
}

a {
    color: #c60f13;
    text-decoration: none;
}
user agent stylesheet
a:-webkit-any-link {
    color: -webkit-link;
    text-decoration: underline;
    cursor: auto;
}
Inherited from div.search-result-summary
.search-result>.search-result-summary {
    float: left;
    font-weight: bold;
    margin-bottom: 20px;
    width: 250px;
}

.clear {
    clear: both;
}

.clear {
    clear: both;
}
user agent stylesheet
div {
    display: block;
}
Inherited from div.search-result-summary
.search-result>.search-result-summary {
    float: left;
    font-weight: bold;
    margin-bottom: 20px;
    width: 250px;
}

.search-result a.details {
    font-size: 10px;
    color: #810101;
    text-decoration: none;
}

a {
    color: #c60f13;
    text-decoration: none;
}
user agent stylesheet
a:-webkit-any-link {
    color: -webkit-link;
    text-decoration: underline;
    cursor: auto;
}
Inherited from div.search-result-summary
.search-result>.search-result-summary {
    float: left;
    font-weight: bold;
    margin-bottom: 20px;
    width: 250px;
}

.search-result pre {
    background-color: transparent;
    border: 0;
    float: left;
    font-family: 'Inconsolata';
    margin-bottom: 20px;
    margin-left: 20px;
    padding-top: 0;
}

pre {
    display: block;
    padding: 8.5px;
    margin: 0 0 9px;
    font-size: 12.025px;
    line-height: 18px;
    word-break: break-all;
    word-wrap: break-word;
    white-space: pre;
    white-space: pre-wrap;
    background-color: #f5f5f5;
    border: 1px solid #ccc;
    border: 1px solid rgba(0,0,0,0.15);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
code, pre {
    padding: 0 3px 2px;
    font-family: Menlo,Monaco,Consolas,"Courier New",monospace;
    font-size: 12px;
    color: #333333;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}
user agent stylesheet
pre, xmp, plaintext, listing {
    display: block;
    font-family: monospace;
    white-space: pre;
    margin: 1em 0px 1em;
}
Inherited from div.search-result

.clear {
    clear: both;
}
.clear {
    clear: both;
}
user agent stylesheet
div {
    display: block;
}
Inherited from div.search-result
.search-result {
    border-bottom: 1px solid #eee;
    line-height: 12px;
    margin-bottom: 10px;
    text-shadow: none;
}
.search-result>div.ip a {
    color: #444;
    font-size: 18px;
    font-weight: bold;
    line-height: 20px;
}
a {
    color: #c60f13;
    text-decoration: none;
}
user agent stylesheet
a:-webkit-any-link {
    color: -webkit-link;
    text-decoration: underline;
    cursor: auto;
}

.search-result pre {
    background-color: transparent;
    border: 0;
    float: left;
    font-family: 'Inconsolata';
    margin-bottom: 20px;
    margin-left: 20px;
    padding-top: 0;
}

pre {
    display: block;
    padding: 8.5px;
    margin: 0 0 9px;
    font-size: 12.025px;
    line-height: 18px;
    word-break: break-all;
    word-wrap: break-word;
    white-space: pre;
    white-space: pre-wrap;
    background-color: #f5f5f5;
    border: 1px solid #ccc;
    border: 1px solid rgba(0,0,0,0.15);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
body>.container-fluid {
    padding-left: 0;
    padding-right: 0;
}

body>.container, body>.container-fluid {
    text-shadow: 1px 1px white;
}
.container-fluid {
    padding-right: 20px;
    padding-left: 20px;
}
user agent stylesheet
div {
    display: block;
}
Inherited from body
body {
    background: url(https://static.shodan.io/shodan/img/bg-whiter.gif);
    font-family: 'Open Sans','Helvetica';
}
body {
    margin: 0;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 13px;
    line-height: 18px;
    color: #333333;
    background-color: #ffffff;
}
</style>

<?php $form=ActiveForm::begin([
        'method' => 'post',
        'action' => '/search/shodan'
    ]);?>

<div class="box box-solid box-default">
    <div class="box-header">
        <div class="input-group col-xs-6 col-md-6 col-md-offset-3 col-center-block">
        <input type="text" name="query" class="form-control" placeholder="Search..." value="<?php echo $q?>">
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