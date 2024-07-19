import "./bootstrap";
import { Livewire } from "../../vendor/livewire/livewire/dist/livewire.esm";
import { formatNumeral } from "cleave-zen";
import puppeteer from "puppeteer";
// You will need a ResizeObserver polyfill for browsers that don't support it! (iOS Safari, Edge, ...)
import ResizeObserver from "resize-observer-polyfill";

window.puppeteer = puppeteer;

window.ResizeObserver = ResizeObserver;
window.formatNumeral = formatNumeral;
window.Alpine = Alpine;

// asset loading
import.meta.glob(["../assets/**"]);

Livewire.start();
