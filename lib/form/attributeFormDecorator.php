<?php
class attributeFormDecorator extends sfWidgetFormSchemaFormatter {
  protected
    $rowFormat       = "
      <div class=\"row\">
        <div class=\"label\">%label%</div>
        <div class=\"field\">%field%%hidden_fields%%error% %help%</div>
      </div>\n",
    $errorRowFormat  = "
      <div class=\"row\">
        <div class=\"field\">%errors%</div>
      </div>\n",
    $helpFormat      = "<span class=\"vtip\" title=\"%help%\">?</span>",
    $decoratorFormat = " %content%",
    $errorListFormatInARow     = "  %errors%  \n",
    $errorRowFormatInARow      = "    <span class=\"error_list\">%error%</span>\n",
    $namedErrorRowFormatInARow = "    <span class=\"error_list\">%name%: %error%</span>\n";
}