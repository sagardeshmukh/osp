<?php
$hiddenField = new sfWidgetFormInputHidden();
$textAreaField = new sfWidgetFormTextarea();
$selectField = new sfWidgetFormChoice(array('choices' => $i18nLanguages));
?>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("language", "1");
    function translateFields() {
        var targetLanguage = $("#sf_culture").val().toLowerCase();
        $('.msgRows').each(function(i, element){
            var textAreas = $(element).find('textarea');
            var sourceText = (targetLanguage == "en") ? $(textAreas[0]).val() : $(textAreas[0]).val();
            console.log(sourceText);
            google.language.translate(sourceText, "<?php echo $sf_culture?>", targetLanguage, function(result) {
                if (!result.error) {
                    $(textAreas[1]).val(result.translation);
                }
            });
        });
    }
    function changeLang(element){
        $.ajax({
            url : '<?php echo url_for('translation/getTranslation')?>',
            data: { sf_culture: $(element).val() },
            dataType: 'json',
            success: function(data){
                $('.sandbad').val('');
                $.each(data, function(index, value){
                   $('#target_' + index).val(value);
                });
            }
        });
    }
</script>
<h3>Create Translation</h3>
<br />
<form method="post" action="<?php echo url_for("translation/updateTranslation") ?>">
    <table border="1" width="90%" align="center">
        <tr>
            <td colspan="4">
                <input type="submit" value="Translate (GOOGLE)"  onclick="translateFields(); return false;"/>
                <input type="submit" value="Save" />
            </td>
        </tr>
        <tr><td colspan="4">&nbsp</td></tr>
        <tr>
            <td><h3>Id</h3></td>
            <td><h3>Source text</h3></td>
            <td><h3>Target Language :<?php echo $selectField->render('sf_culture', $sf_culture, array('onchange' => 'changeLang(this);')) ?></h3></td>
        </tr>
        <?php foreach ($messages as $id => $message): ?>
        <tr class="msgRows">
            <td><?php echo $hiddenField->render('id['. $id .']', $id) ?><?php echo $id ?></td>
            <td width="40%"><?php echo $textAreaField->render('source['. $id .']', $message['source'], array('style' => 'display:none;')) ?><?php echo $message['source'] ?></td>
            <td width="50%"><?php echo $textAreaField->render('target['. $id .']', isset($message[$sf_culture]['target']) ? $message[$sf_culture]['target'] : '', array('class' => 'sandbad')) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr><td colspan="4">&nbsp</td></tr>
        <tr>
            <td colspan="4">
                <input type="submit" value="Translate (GOOGLE)"  onclick="translateFields(); return false;"/>
                <input type="submit" value="Save" />
            </td>
        </tr>
    </table>
</form>