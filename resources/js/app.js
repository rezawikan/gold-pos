import './bootstrap';
import {Livewire} from '../../vendor/livewire/livewire/dist/livewire.esm';
import 'iconify-icon';

import SimpleBar from "simplebar";
import "simplebar/dist/simplebar.css";

// You will need a ResizeObserver polyfill for browsers that don't support it! (iOS Safari, Edge, ...)
import ResizeObserver from 'resize-observer-polyfill';

// Initialization for ES Users
import {Dropdown, initTWE, Modal, Offcanvas, Ripple} from 'tw-elements';

window.ResizeObserver = ResizeObserver;

window.SimpleBar = SimpleBar;


initTWE({Offcanvas, Ripple, Dropdown, Modal});
// asset loading
import.meta.glob(["../assets/**"]);

Livewire.start();