<div style="width: 100%">
    <?php foreach ($Feature['groups'] as $valuemoi): ?>
        <div style="float: left;clear: both;padding-top: 5px;line-height: 20px">
            <label style="float: left;width: 110px"><?= $valuemoi->public_name; ?></label>
            <?php foreach ($Feature['attributes'] as $attribute): ?>
                <?php if ($attribute->id_attribute_group == $valuemoi->id_attribute_group && $attribute->id_attribute_group == 2) { ?>
                    <label class="label1" >
                        <input type="radio" value="<?= $attribute->id_attribute ?>"  style="opacity: 0;position: absolute;cursor: pointer;"/>
                        <label style="background-color:<?= $attribute->color ?>;display: block;height: 20px;min-width: 26px;line-height: 20px;padding: 0px 5px;"></label>
                    </label>
                <?php } elseif ($attribute->id_attribute_group == $valuemoi->id_attribute_group) { ?>
                    <label class="label1">
                        <input type="radio" value="<?= $attribute->id_attribute ?>"  style="opacity: 0;position: absolute;cursor: pointer;margin-top: 3px"/>
                        <label style="background-color:<?= $attribute->color ?>;display: block;height: 20px;min-width: 26px;line-height: 20px;padding: 0px 5px;"><?= $attribute->name; ?></label>
                    </label>
                <?php } ?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>