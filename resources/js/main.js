// Check if the current page is the last page in history
if (performance.navigation.type === 2) {
    // This means the page was loaded by navigating back or forward in history
    // Reload the page
    location.reload(true); // The true parameter forces a reload from the server, not the cache
}