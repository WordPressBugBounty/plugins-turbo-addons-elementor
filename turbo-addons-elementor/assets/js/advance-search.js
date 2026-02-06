document.addEventListener('DOMContentLoaded', () => {
    const initializeSearchFunctionality = () => {
        const searchInput = document.getElementById('trad-advance-search-bar');
        const resultContainer = document.getElementById('trad-advance-search-results');

        if (!searchInput || !resultContainer) {
            // console.warn('Search elements not found.');
            return;
        }

        // Fetch search data from WordPress REST API
        const fetchSearchData = async (query) => {
            try {
                const response = await fetch(`/wp-json/wp/v2/search?search=${query}`);
                return await response.json();
            } catch (error) {
                // console.error('Error fetching search data:', error);
                return [];
            }
        };

        // Listen to the input event on the search bar
        searchInput.addEventListener('input', async () => {
            const query = searchInput.value.toLowerCase();

            // Hide the results container if the input is empty
            if (!query) {
                resultContainer.classList.add('trad-advance-search-hidden');
                resultContainer.innerHTML = '';
                document.querySelector('.trad-advance-search-results-container').style.border = "none";
                return;
            } else {
                resultContainer.classList.remove('trad-advance-search-hidden');
            }

            const results = await fetchSearchData(query);

            // Clear previous results
            resultContainer.innerHTML = '';

            if (results && results.length > 0) {
                resultContainer.style.display = "block";

                results.forEach(item => {
                    const resultItem = document.createElement('div');
                    resultItem.classList.add('trad-advance-search-result-item');
                    resultItem.textContent = item.title; // Show the title
                    resultItem.dataset.url = item.url;  // Use the correct URL field

                    // Redirect to the result's URL when clicked
                    resultItem.addEventListener('click', () => {
                        try {
                            const parsedUrl = new URL(item.url, window.location.origin);
                            if (parsedUrl.origin === window.location.origin) {
                                window.location.href = parsedUrl.href;
                            }
                            // Else: do nothing silently
                        } catch (e) {
                            // Silently ignore invalid URL
                        }
                    });
                    
                    resultContainer.appendChild(resultItem);
                });
            } else {
                // console.log('No matches found');
                // Show a no results message if no matches were found
                resultContainer.style.display = "block"; // Ensure the container is visible
                resultContainer.innerHTML = '<div class="trad-advance-search-no-results">No results found</div>';
            }
        });
    };

    // Initialize search functionality immediately
    initializeSearchFunctionality();

    // Use MutationObserver to reinitialize functionality in Elementor editor mode
    const observer = new MutationObserver(() => {
        if (typeof elementor !== 'undefined' && elementorFrontend.isEditMode()) {
            initializeSearchFunctionality();
        }
    });

    // Observe changes to the DOM
    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });
});
