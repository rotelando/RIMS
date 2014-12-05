<?php
/**
 * Created by PhpStorm.
 * User: RotelandO
 * Date: 10/28/14
 * Time: 11:53 AM
 */
?>

<div id="fuelux-wizard" class="row-fluid hide" data-target="#step-container" style="display: block;">
    <ul class="wizard-steps">
        <li data-target="#step1" class="<?php if(isset($active) && $active == 'country') echo 'active'; ?>" style="min-width: 20%; max-width: 20%;">
            <span class="step">1</span>
            <span class="title">Country</span>
        </li>

        <li data-target="#step2" style="min-width: 20%; max-width: 20%;" class="<?php if(isset($active) && $active == 'region') echo 'active'; ?>">
            <span class="step">2</span>
            <span class="title">Region</span>
        </li>

        <li data-target="#step3" style="min-width: 20%; max-width: 20%;" class="<?php if(isset($active) && $active == 'subregion') echo 'active'; ?>">
            <span class="step">3</span>
            <span class="title">Subregion</span>
        </li>

        <li data-target="#step4" style="min-width: 20%; max-width: 20%;" class="<?php if(isset($active) && $active == 'state') echo 'active'; ?>">
            <span class="step">4</span>
            <span class="title">State</span>
        </li>
        <li data-target="#step5" style="min-width: 20%; max-width: 20%;" class="<?php if(isset($active) && $active == 'territory') echo 'active'; ?>">
            <span class="step">5</span>
            <span class="title">Territory</span>
        </li>
        <li data-target="#step5" style="min-width: 20%; max-width: 20%;" class="<?php if(isset($active) && $active == 'lga') echo 'active'; ?>">
            <span class="step">6</span>
            <span class="title">LGA</span>
        </li>

        <li data-target="#step5" style="min-width: 20%; max-width: 20%;" class="<?php if(isset($active) && $active == 'location') echo 'active'; ?>">
            <span class="step">7</span>
            <span class="title">Retail Block</span>
        </li>
    </ul>
</div>