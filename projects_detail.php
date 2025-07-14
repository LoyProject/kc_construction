<?php require_once 'header.php'; ?>

<div class="container mx-auto w-full overflow-hidden relative">
    <div id="project-detail">
        <!-- Project details will be populated here -->
    </div>
</div>

<?php require_once 'footer.php'; ?>

<script>
    $(document).on('click', '.floor-item', function () {
        const selectedFloorId = $(this).attr('data-id');
        const selectedFloorLabel = $(this).text().trim();

        if (selectedFloorId) {
            sessionStorage.setItem('selectedFloorId', selectedFloorId);
            sessionStorage.setItem('selectedFloorLabel', selectedFloorLabel);
        }

        window.location.href = 'projects';
    });

    $(document).on('click', '.facade-item', function () {
        const selectedFacadeId = $(this).attr('data-id');
        const selectedFacadeLabel = $(this).text().trim();

        if (selectedFacadeId) {
            sessionStorage.setItem('selectedFacadeId', selectedFacadeId);
            sessionStorage.setItem('selectedFacadeLabel', selectedFacadeLabel);
        }

        window.location.href = 'projects';
    });
</script>