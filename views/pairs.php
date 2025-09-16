<h1>Pairs</h1>

<div class="actions">

    <form action="/pairs" method="get">
        <input type="text" value="<?= $origin ?>" name="origin" />
        <input type="text" value="<?= $copy ?>" name="copy" />

        <input type="submit" name="filter" value="Filter" />
        <input type="submit" name="remove" value="Remove" />
    </form>

</div>

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


    .actions {
        display: flex;
        gap: 0.5rem;
        background: #dfdfdfff;
        padding: 1rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }

    input[type="text"] {
        padding: 0.6rem 0.8rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.5rem;
        flex: 1;
    }

    input[type="submit"] {
        padding: 0.6rem 1rem;
        border: none;
        border-radius: 0.5rem;
        background: #0f172a;
        color: white;
        font-weight: 600;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        opacity: 0.85;
    }

    /* Dark mode */
    @media (prefers-color-scheme: dark) {
        body {
            background: #0f172a;
            color: #f1f5f9;
        }

        .actions {
            background: #2b3950ff;
            box-shadow: 0 6px 18px rgba(0,0,0,0.6);
        }

        input[type="text"] {
            background: #0f172a;
            color: #f1f5f9;
            border: 1px solid #334155;
        }

        input[type="submit"] {
            background: #38bdf8;
            color: #0f172a;
        }
    }

</style>