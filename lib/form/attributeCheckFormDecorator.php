<?php
class attributeCheckFormDecorator extends sfWidgetFormSchemaFormatter {
  protected
    $rowFormat       = "
      <div class=\"detail\">
        <h6 class=\"detail-header\">%label%</h6>
        %field%%hidden_fields%%error%
        <div class=\"clear\"></div>
      </div>\n",
    $errorRowFormat  = "
      <div class=\"row\">
        <div class=\"field\">%errors%</div>
      </div>\n",
    $helpFormat      = '%help%',
    $decoratorFormat = " %content%",
    $errorListFormatInARow     = "  %errors%  \n",
    $errorRowFormatInARow      = "    <span class=\"error_list\">%error%</span>\n",
    $namedErrorRowFormatInARow = "    <span class=\"error_list\">%name%: %error%</span>\n";
}