document.addEventListener("DOMContentLoaded", function () {
    const filterType = document.getElementById("codowps-filter-type");
    const filterSource = document.getElementById("codowps-filter-source");
    const pluginItems = document.querySelectorAll(".codowps-plugin-item");

    function filterPlugins() {
        const type = filterType.value;
        const source = filterSource.value;

        pluginItems.forEach(item => {
            const itemType = item.getAttribute("data-type");
            const itemSource = item.getAttribute("data-source");
            if ((type === "all" || itemType === type) && (source === "all" || itemSource === source)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    }

    filterType.addEventListener("change", filterPlugins);
    filterSource.addEventListener("change", filterPlugins);
});
