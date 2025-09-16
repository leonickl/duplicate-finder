<h1>Pairs</h1>

<div style="display: flex; flex-direction: column; gap: 20px;">

    <?php foreach($pairs as $pair): ?>
        <div class="pair">

            <div>
                <img src="/image?file=<?= urlencode($pair[0]) ?>" height="350px" />
            </div>

            <span><?= $pair[0] ?></span>
            <span><?= $pair[1] ?></span>

        </div>
    <?php endforeach ?>

</div>

<style>

    .pair {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

</style>