<h1>All Duplicates</h1>

<div style="display: flex; flex-direction: column; gap: 20px;">

    <?php foreach($pairs as $hash => $files): ?>
        <div class="pair">

            <div>
                <img src="/image?file=<?= urlencode($files[0]->path) ?>" />
            </div>

            <?php foreach($files as $file): ?>

                <span>
                    <?= $file->path ?>
                    <a href="/remove-file/<?= $file->id ?>?__method=post">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path color="#c12929" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                        </svg>
                    </a>
                </span>

            <?php endforeach ?>

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

    img {
        max-height: 350px;
        max-width: 100%;
    }

    span a {
        position: relative;
        top: 3px;
    }

</style>