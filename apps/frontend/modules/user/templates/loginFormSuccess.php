<form method="post" id="login_form" action="<?php echo url_for("user/login")?>" onSubmit="$('#login_form').submit(); return false;">
    <?php echo $form->renderGlobalErrors() ?>
    <input type="hidden" name="product_id" value="<?php echo $product_id?>" />
	<input type="hidden" name="mapView" value="<?php echo $mapView?>" />
    <?php echo $form->renderHiddenFields(false) ?>
    <table cellpadding="5">
        <tbody>
            <tr>
                <th><?php echo $form["username"]->renderLabel() ?></th>
                <td>
                    <span> <?php echo $form["username"] ?></span>
                    <span class="desc" style="font-weight: 100;"><?php echo $form["username"]->renderHelp() ?></span><?php echo $form["username"]->renderError() ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form["password"]->renderLabel() ?></th>
                <td>
                    <span><?php echo $form["password"] ?></span>
                    <span class="desc" style="font-weight: 100;"><?php echo $form["password"]->renderHelp() ?></span><?php echo $form["password"]->renderError() ?>
                </td>
            </tr>

            <tr>
                <th></th>
                <td>
                    <span style=""><?php echo $form["savepass"] ?></span>
                    <label for="remember_field"><?php echo __('Remember me')?>.</label> </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="<?php echo __('Login')?>"/><a href="<?php echo url_for('user/new') ?>"><?php echo __('Register') ?>
                </td>
            </tr>
        </tbody>
    </table>
</form>
