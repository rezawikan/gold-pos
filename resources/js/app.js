import './bootstrap';
import {Livewire} from '../../vendor/livewire/livewire/dist/livewire.esm';
import 'iconify-icon';

import {formatNumeral} from "cleave-zen";

// You will need a ResizeObserver polyfill for browsers that don't support it! (iOS Safari, Edge, ...)
import ResizeObserver from 'resize-observer-polyfill';

window.ResizeObserver = ResizeObserver;
window.formatNumeral = formatNumeral;
window.Alpine = Alpine;

// asset loading
import.meta.glob(["../assets/**"]);


Livewire.start();
