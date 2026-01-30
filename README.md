# RadicalMart UIkit

**RadicalMart UIkit** is a UI integration package for RadicalMart that provides layouts, helpers, and UI bindings based on **UIkit**.

It does not implement business logic and does not alter RadicalMart core behavior.
Its purpose is to supply a consistent UI layer for rendering RadicalMart data.

---

## Purpose

This package connects RadicalMart with **UIkit-based front-end rendering**.

It provides:
- ready-to-use layouts for RadicalMart entities,
- UI helpers and overrides aligned with UIkit conventions,
- a clean separation between data logic and presentation.

The package exists to keep UI concerns **out of RadicalMart core**.

---

## What this package does

- Supplies UIkit-compatible layouts for:
  - products,
  - categories,
  - fields,
  - filters,
  - meta-product variability.
- Provides UI helpers and view overrides used by RadicalMart.
- Ensures consistent markup and structure across UIkit-based templates.

---

## What this package does NOT do

- ❌ Does not implement product logic
- ❌ Does not handle pricing, stock, or orders
- ❌ Does not modify RadicalMart core behavior
- ❌ Does not enforce a specific template

This package is **purely presentational**.

---

## Architecture role

Within the RadicalMart ecosystem:

```

RadicalMart Core
↓
Data & Events
↓
UI Integration Layer
↓
UIkit Layouts

```

RadicalMart UIkit represents the **UI integration layer**.

---

## Layout system

The package uses Joomla layouts to render RadicalMart data.

Layouts are responsible for:
- HTML structure,
- UIkit classes,
- component composition.

All data preparation happens **before** rendering.

---

## Usage

The package is intended for:
- projects using UIkit-based templates,
- developers building custom UIkit layouts on top of RadicalMart,
- replacing or extending default layouts without touching core code.

Layouts can be overridden using standard Joomla layout override mechanisms.

---

## Customisation

Developers are encouraged to:
- copy layouts into the template overrides,
- adjust markup and UIkit modifiers,
- keep business logic out of templates.

The package is designed to be extended, not edited directly.

---

## Ecosystem role

RadicalMart UIkit is one of several possible UI integrations.

It can coexist with:
- custom UI layers,
- alternative front-end frameworks,
- headless or API-driven front ends.
