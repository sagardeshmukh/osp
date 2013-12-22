<?php
$sName = $xmlParams['ssav_title'];
$savs = $xmlParams['savs'];
$ssav_object = $xmlParams['ssav_object'];
$ssav_attributes = $xmlParams['ssav_attributes'];
$ssav_attribute_values = $xmlParams['ssav_attribute_values'];
?>
<div class="ov-fl">
    <div class="ov-t" id="v4-12929852889205_tpDiv"><b><i></i></b></div>
<div class="ov-c1">
<div class="ov-c2">
<div class="ov-cnt ov-p20" style="height: auto;
    visibility: visible;
    width: 640px;">
<div id="cnv4-12929222864235">
    <div id="hcv4-12929222864235" class="ov-s" style="cursor: move;">
        <div class="asf-h">
            <div class="title">
                <?php echo $ssav_object->getName() ?>
            </div>
        </div>
    </div>
    <div>
        <div class="asf-b">
            <form class="asf-f" id="v4-12929222864232" onsubmit="Yozoa.Browse.submit(); return false;">
                <table cellspacing="0" cellpadding="0" class="asf-f" style="width: 615px;">
                    <tbody>
                        <tr class="dynamic">
                            <td class="frame">
                                <div class="frame" style="width: 473px;">
                                    <div class="ajax-throbber" id="v4-12929222864233" style="display: none; width: 473px; height: 323px;">
                                    </div>
                                    <div class="asf-e" style="display: none;">
                                        <div class="msg" id="SystemFailure" style="display: none;">
                                            System failure. Please try your request again later.
                                        </div>
                                        <div class="msg" id="MakeSelection" style="display: none;">
                                            Please make a selection before continuing.
                                        </div>
                                    </div>
                                    <div class="asf-m">
                                        <div class="msg" id="MoreChoices">
                                            More choices may become available if you remove some of your selections.
                                        </div>
                                        <div class="msg" id="TheseChoices">
                                            These choices may become available if you remove other selections
                                        </div>
                                    </div>
                                    <div class="asf-c" style="display: block; width: 435px;">
                                        <div class="asf-p">
                                            <div id="e111">
                                                <table width="100%" cellspacing="0" cellpadding="0" class="asf-c">
                                                    <tbody>
                                                        <tr>
                                                            <td class="asf-c">
                                                                <?php $i=0; foreach($ssav_attribute_values as $ssav): ?>
                                                                <?php if($i == count($ssav_attribute_values)/2): ?>
                                                                   </td><td>
                                                                <?php endif; ?>
                                                                <div>
                                                                    <input type="checkbox" class="radio" id="<?php echo $ssav_object ?>0" <?php echo in_array($ssav->getId(), $savs) ? 'checked': '' ?> name="<?php echo $ssav_object->getId() ?>" value="<?php echo $ssav->getId() ?>">
                                                                    <div class="label">
                                                                        <label for="<?php echo $ssav_object ?>0">
                                                                            <?php echo $ssav->getValue(); $i++; ?>
                                                                        </label>
                                                                        <span class="cnt">
                                                                            (<?php echo $ssav->getNbProduct() ?>)
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <?php endforeach; ?>
																<?php if($savs){ ?>
																<input type="hidden" name = "av" id="av" value="<?php echo implode("|",$savs); ?>" />
																<?php } ?>
																
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="options" style="width: 125px;">
                                <div class="options" style="width: 125px;">
                                    <div class="title">
                                        Other options:
                                    </div>
                                    <div class="scroll">
                                        <div class="prev prev-d" style="visibility: hidden;">
                                            <div class="tab" id="e90">
                                            </div>
                                        </div>
                                        <div class="next next-d" style="visibility: hidden;">
                                            <div class="tab" id="e91">
                                            </div>
                                        </div>
                                        <div class="others" style="top: 0px;">
                                            <?php foreach($ssav_attributes as $attribute): ?>
                                            <div class="other-v">
                                                <a href="javascript:;" id="<?php echo $attribute->getId() ?>" class="<?php echo $ssav_object->getId() == $attribute->getId() ? 'selected': '' ?>"><?php echo $attribute->getName(); ?></a>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="controls">
                            <td class="controls">
                                <div class="controls">
                                    <a href="javascript:;" id="e92">Cancel</a>
                                    <b class="bn-w bn-m bn-pad psb-S" id="v4-12929222864234">
                                        <i>
                                            Go
                                        </i>
                                        <span class="bn-b psb-b psb-S" id="spn_v4-12929222864234">
                                            <input type="submit" title="" value="Go" name="" id="but_v4-12929222864234">
                                            <b id="txt_v4-12929222864234">
                                                Go
                                            </b>
                                        </span>
                                    </b>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
    <a class="ov-cl" id="v4-12929852889205_CB" href="javascript:;"></a>
</div>
    </div>
    </div>
    <u></u>
    <div class="ov-b"><b><i></i></b></div>
    </div>
<script type="text/javascript">
$(document).ready(function(){
    $('.other-v a').click(function(){
        var sa = $(this).attr('id');
//        var ma = $(this).attr('id');
        var params = decodeURIComponent($('.asf-c input').filter("input:enabled, input[type=hidden]").serialize());
        var _ssan = $('.asf-c input').attr('name');
        if(Yozoa.Browse.gParams[sa] == params && Yozoa.Browse.isChanged[sa] == false && Yozoa.Browse.prevData[sa]){
            Yozoa.Browse.processCResponse({
                'data': Yozoa.Browse.prevData[sa],
                '_ssan': _ssan,
                'sa': sa,
                'open': true

            });
        }else{
            Yozoa.Browse.C({
            'open'  : false,
            'params': params,
            '_ssan': _ssan,
            'sa': sa
        });
        }


   });
});
</script>