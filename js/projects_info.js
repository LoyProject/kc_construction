function fetchProjects(page = 1, callback) {
    const style = $('#dropdownInput-style').attr('data-id') || '';
    const type = $('#dropdownInput-type').attr('data-id') || '';
    const floor = $('#dropdownInput-floor').attr('data-id') || '';
    const area = $('#dropdownInput-area').attr('data-id') || '';
    const facade = $('#dropdownInput-facade').attr('data-id') || '';

    $.ajax({
        url: 'backend/process_fetch_projects.php',
        method: 'GET',
        data: { page: page, limit: 16, style: style, type: type, floor: floor, area: area, facade: facade },
        beforeSend: function() {
            // Optionally show a loading indicator
            console.log('Fetching projects...');
        },
        dataType: 'json',
        success: function(data) {
            if (typeof callback === 'function') {
                callback(data);
            }
            var $projectTitle = $('#project-title');
            if (data.success && Array.isArray(data.projects) && data.projects.length > 0) {
                $projectTitle.text(data.projects[0].name);

            } else if (data.success && Array.isArray(data.projects) && data.projects.length === 0) {
                $projectTitle.text('No projects found');
            } else {
                console.error('Failed to fetch projects:', data.message);
                $projectTitle.text('Error fetching projects title');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching projects:', textStatus, errorThrown);
            if (typeof callback === 'function') {
                callback({ success: false, message: textStatus });
            }
        }
    });
}

// Usage example:
$(document).ready(function() {
    fetchProjects(1, function(data) {
        // Handle data here, e.g., pass to a rendering function
        console.log(data);
    });
});
