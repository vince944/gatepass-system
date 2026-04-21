{{-- Tom Select for searchable employee dropdown (inventory portal). Shared by coordinator & admin dashboard. --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css">
<style>
    /* Match Asset Inventory Management field height and rounded corners */
    .inventory-employee-select.ts-wrapper {
        width: 100%;
        min-height: 42px;
    }
    .inventory-employee-select .ts-control {
        min-height: 42px;
        padding: 8px 12px;
        border-radius: 0.75rem;
        border: 1px solid #d1d5db;
        background-color: #fff;
        font-size: 14px;
        line-height: 1.25;
        box-shadow: none;
    }
    .inventory-employee-select.ts-wrapper.dropdown-active .ts-control,
    .inventory-employee-select.ts-wrapper.focus .ts-control,
    .inventory-employee-select.ts-wrapper:focus-within .ts-control {
        border-color: #003b95;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 59, 149, 0.2);
    }
    .inventory-employee-select .ts-control input {
        font-size: 14px !important;
        min-width: 6rem;
    }
    .inventory-employee-select-dropdown {
        border-radius: 0.75rem;
        border: 1px solid #d1d5db;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        margin-top: 4px;
        z-index: 10000;
        max-height: min(320px, 70vh);
        overflow: hidden;
    }
    .inventory-employee-select-dropdown .ts-dropdown-content {
        max-height: min(280px, 65vh);
        overflow-y: auto;
    }
    .inventory-employee-select .optgroup-header {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #003b95;
        background: #f8fafc;
        padding: 8px 12px;
    }
    .inventory-employee-select-dropdown .option {
        font-size: 14px;
        padding: 10px 12px;
    }
    .inventory-employee-select-dropdown .option.active {
        background: rgba(0, 59, 149, 0.08);
    }
    .inventory-employee-select-dropdown .dropdown-input {
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        margin: 8px;
        width: calc(100% - 16px) !important;
        font-size: 14px;
        padding: 8px 10px;
    }
</style>
