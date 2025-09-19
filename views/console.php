<h1>Console</h1>

<pre><?php foreach($lines as $line): ?><?= $line ?><?php endforeach ?></pre>

<?php if(isset($back)): ?>
    <a class="button-blue" href="<?= $back ?>">Back</a>
<?php endif ?>

<style>

    .button-blue {
        background-color: #3b82f6;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.375rem;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .button-blue:hover {
        background-color: #2563eb;
    }

    pre {
        margin-bottom: 20px;
    }

</style>