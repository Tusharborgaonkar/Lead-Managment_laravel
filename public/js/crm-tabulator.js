/**
 * CRM Tabulator — Shared Factory
 * Creates Tabulator instances with CRM-standard defaults.
 * All tables are visually identical to the existing Tailwind design.
 *
 * Usage:
 *   const table = createCRMTable('#leads-table', columns, data, { paginationSize: 15 });
 *
 * Future Ajax:
 *   const table = createCRMTable('#leads-table', columns, null, {
 *       ajaxURL: '/api/leads',
 *       pagination: 'remote'
 *   });
 */

// Debug flag — set to true during development for console logging
window.CRM_TABLE_DEBUG = false;

function crmTableLog(...args) {
    if (window.CRM_TABLE_DEBUG) {
        console.log('[CRM-Table]', ...args);
    }
}

function crmTableWarn(...args) {
    if (window.CRM_TABLE_DEBUG) {
        console.warn('[CRM-Table]', ...args);
    }
}

/**
 * Create a CRM-styled Tabulator table.
 *
 * @param {string}   selector  - CSS selector for the container div
 * @param {Array}    columns   - Tabulator column definitions
 * @param {Array|null} data    - Data array (null if using ajaxURL)
 * @param {Object}   overrides - Optional setting overrides
 * @returns {Tabulator} table instance
 */
function createCRMTable(selector, columns, data, overrides) {
    overrides = overrides || {};

    var config = {
        // Data
        data: data || [],

        // Layout — match existing table
        layout: "fitDataFill",
        responsiveLayout: false,

        // Interactive features
        movableColumns: true,
        resizableColumns: false,
        resizableRows: false,

        // Sorting
        headerSort: true,
        headerSortClickElement: "header",

        // No tooltips
        tooltips: false,

        // Pagination
        pagination: "local",
        paginationSize: 10,
        paginationButtonCount: 5,
        paginationSizeSelector: false,

        // Placeholder
        placeholder: "<div class='py-12 text-center text-slate-400 font-medium text-sm'>No records found.</div>",

        // Columns
        columns: columns,

        // Row rendering complete — re-init Lucide icons in new cells
        renderComplete: function () {
            if (typeof lucide !== 'undefined') {
                // Short delay to ensure DOM is ready for Lucide to scan
                setTimeout(function () {
                    crmTableLog('Running Lucide createIcons for renderComplete', selector);
                    lucide.createIcons();
                }, 100);
            }
            crmTableLog('Table rendered:', selector);
        },

        // Table built callback
        tableBuilt: function () {
            crmTableLog('Table built event for', selector);
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            crmTableLog('Table built:', selector);
        },

        // Error callback
        dataLoadError: function (error) {
            crmTableWarn('Data load error:', selector, error);
        }
    };

    // Merge overrides
    for (var key in overrides) {
        if (overrides.hasOwnProperty(key)) {
            config[key] = overrides[key];
        }
    }

    // If ajaxURL is provided, clear inline data
    if (overrides.ajaxURL) {
        config.data = [];
    }

    crmTableLog('Initializing table:', selector, 'rows:', (data ? data.length : 'ajax'));

    try {
        var table = new Tabulator(selector, config);

        // FOOLPROOF FALLBACK: Call lucide again after a short delay
        setTimeout(function () {
            if (typeof lucide !== 'undefined') {
                crmTableLog('Running Lucide fallback for', selector);
                lucide.createIcons();
            }
        }, 200);

        return table;
    } catch (e) {
        crmTableWarn('Failed to initialize table:', selector, e);
        throw e;
    }
}

/**
 * Helper: Apply combined filters from external inputs to a Tabulator instance.
 * Accepts an array of filter objects: { field, type, value }
 * Removes empty filters automatically.
 *
 * @param {Tabulator} table
 * @param {Array} filters - [{ field: 'name', type: 'like', value: 'john' }, ...]
 */
function crmTableSetFilters(table, filters) {
    if (!table) return;

    var activeFilters = filters.filter(function (f) {
        return f.value !== '' && f.value !== 'all' && f.value !== null && f.value !== undefined;
    });

    if (activeFilters.length === 0) {
        table.clearFilter();
    } else {
        table.setFilter(activeFilters);
    }

    crmTableLog('Filters applied:', activeFilters);
}
