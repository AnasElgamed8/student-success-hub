/**
 * GLOBAL JS: global.js
 * Shared functions used across all pages of the Student Success Hub.
 */

// 1. Notification Helper
// A simple function to show a temporary alert and then hide it.
function showToast(message, type = 'success') {
    // We can expand this later to use a proper Bootstrap Toast.
    alert(type === 'success' ? "✅ " + message : "❌ " + message);
}

// 2. Form Validation
// A generic function to ensure required fields are not just whitespace.
function validateRequired(fields) {
    for (let id of fields) {
        const el = document.getElementById(id);
        if (el && el.value.trim() === "") {
            return false;
        }
    }
    return true;
}

console.log("Student Success Hub: Global JS Loaded.");
