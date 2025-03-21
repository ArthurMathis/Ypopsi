<script>
    const notification = Swal.fire({
        title   : "<?= htmlspecialchars($infos['title']) ?>",
        html    : "<?= addslashes($infos['msg']) ?>",
        icon    : "<?= htmlspecialchars($infos['icon']); ?>",
        backdrop: false,

        <?php if(isset($infos['confirm'])): ?>
            showCancelButton : true,
            cancelButtonText : '<?= htmlspecialchars($infos['deleteButton'] ?? "Annuler") ?>',
            confirmButtonText: '<?= htmlspecialchars($infos['confirmButton'] ?? "Confirmer") ?>',
        <?php elseif(isset($infos['button'])): ?>
            confirmButtonText: "<?= htmlspecialchars($infos['text button']) ?>",
        <?php else: ?>
            showConfirmButton: false,
            timer            : 1500,
        <?php endif ?>

        customClass: {
            popup  : 'notification',
            title  : 'notification-title',
            content: 'notification-content',

            <?php if(isset($infos['confirm'])): ?>
                confirmButton: 'action_button reverse_color',
                cancelButton: 'action_button cancel_button',
                actions: 'notification-actions',
            <?php elseif(isset($infos['button'])): ?>
                confirmButton: 'action_button reverse_color',
            <?php endif ?>
        }
    });

    <?php if(isset($infos['confirm'])): ?>
        notification.then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= htmlspecialchars($infos['direction']) ?>';
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                <?php if(isset($infos['back'])): ?>
                    window.location.href = '<?= htmlspecialchars($infos['back']) ?>';
                <?php else: ?>
                    window.history.back();
                <?php endif ?>
            }
        });
    <?php elseif(isset($infos['button'])): ?>
        notification.then((result) => {
            if (result.isConfirmed) {
                <?php if(isset($infos['direction'])): ?>
                    window.location.href = "<?= htmlspecialchars($infos['direction']) ?>";
                <?php else: ?>
                    window.history.back();
                <?php endif ?>
            }
        });
    <?php else: ?>
        setTimeout(() => {
            <?php if(isset($infos['direction'])): ?>
                window.location.href = "<?= htmlspecialchars($infos['direction']) ?>";
            <?php else: ?>
                window.history.back();
            <?php endif ?>
        }, 1500);
    <?php endif ?>
</script>

<style>
    .notification {
        width: 560px;
    }
    .notification-actions {
        margin: 1.25em auto;
    }
    .custom-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-direction: row-reverse;
    }

    b {
        font-family: "Roboto Bold";
    }
</style>
