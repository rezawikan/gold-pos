import './bootstrap';
import {Livewire} from '../../vendor/livewire/livewire/dist/livewire.esm';
import 'iconify-icon';
import DataTable from "datatables.net-dt";
import SimpleBar from "simplebar";
import "simplebar/dist/simplebar.css";
import {formatNumeral} from "cleave-zen";

// You will need a ResizeObserver polyfill for browsers that don't support it! (iOS Safari, Edge, ...)
import ResizeObserver from 'resize-observer-polyfill';

// Initialization for ES Users
import {Dropdown, initTWE, Modal, Offcanvas, Ripple} from 'tw-elements';

window.ResizeObserver = ResizeObserver;

window.SimpleBar = SimpleBar;
window.DataTable = DataTable;
window.Modal = Modal;
window.formatNumeral = formatNumeral;

initTWE({Offcanvas, Ripple, Dropdown, Modal});
// asset loading
import.meta.glob(["../assets/**"]);


new DataTable("#data-table, .data-table", {
    dom: "<'grid grid-cols-12 gap-5 px-6 mt-6'<'col-span-4'l><'col-span-8 flex justify-end'f><'#pagination.flex items-center'>><'min-w-full't><'flex justify-end items-center'p>",
    paging: true,
    ordering: true,
    info: false,
    searching: true,
    lengthChange: false,
    // lengthMenu: [10, 25, 50, 100],
    language: {
        lengthMenu: "Show _MENU_ entries",
        paginate: {
            previous: `<iconify-icon icon="ic:round-keyboard-arrow-left"></iconify-icon>`,
            next: `<iconify-icon icon="ic:round-keyboard-arrow-right"></iconify-icon>`,
        },
        search: "Search:",
    },
});


Livewire.start();
