/*********************************
 *
 * = UI - POPUP MANIPULATION =
 *
 * - makePopupDraggableAndResizable ( Applies boundary-constrained drag and eight-way resize functionality to popups: #lc_popup and #lc_popup2 )
 *
 ***********************************/

// --- CONSTANTS ---
const VISIBLE_HEADER_WIDTH = 50; 
const MIN_WIDTH = 300;
const MIN_HEIGHT = 200;
// const dragOverlay = document.getElementById("dslc-drag-overlay");

/**
 * Applies drag and resize functionality to a given popup element.
 * * @param {string} popupId - The ID of the popup element (e.g., 'lc_popup').
 * @param {string} headerId - The ID of the header element (e.g., 'lc_popupHeader').
 * @param {HTMLElement} [closeBtn=null] - Optional reference to the close button (for drag exclusion).
 */
export function makePopupDraggableAndResizable(popupId, headerId, dragOverlay, closeBtn = null) {
    const popup = document.getElementById(popupId);
    const header = document.getElementById(headerId);

    if (!popup || !header) {
        console.warn(`Live Composer Popup: Could not find elements for ID: ${popupId}`);
        return;
    }

    // --- STATE VARIABLES ---
    let offsetX = 0,
        offsetY = 0,
        isDown = false;
    let isResizing = false;
    let resizeDirection = null;

    // --- DRAG INITIATION ---
    header.addEventListener("mousedown", (e) => {
        if (closeBtn && (e.target === closeBtn || closeBtn.contains(e.target))) {
            return; 
        }
        e.preventDefault();
        isDown = true;
        dragOverlay.style.display = 'block';

        offsetX = e.clientX - popup.offsetLeft;
        offsetY = e.clientY - popup.offsetTop;

        document.body.style.userSelect = 'none';
        popup.style.position = 'absolute';
    });

    // --- RESIZE INITIATION (Scoped to this specific popup) ---
    popup.querySelectorAll('.resize-handle').forEach(handle => {
        handle.addEventListener('mousedown', (e) => {
            e.preventDefault();
            e.stopPropagation(); 
            
            isResizing = true;
            resizeDirection = e.target.getAttribute('data-direction');
            dragOverlay.style.display = 'block'; 
            document.body.style.userSelect = 'none';
            
            // Store initial state
            offsetX = e.clientX;
            offsetY = e.clientY;
            
            popup.initialWidth = popup.offsetWidth;
            popup.initialHeight = popup.offsetHeight;
            popup.initialLeft = popup.offsetLeft;
            popup.initialTop = popup.offsetTop;
        });
    });

    // --- GLOBAL MOUSE UP & MOUSE MOVE Handlers ---
    // Note: To avoid issues with multiple instances, these global listeners
    // should ideally be managed by a controller, but keeping them here
    // means they handle the state for whichever popup initiated the action.

    document.addEventListener("mouseup", () => {
        if (isDown || isResizing) {
            dragOverlay.style.display = 'none'; 
        }
        isDown = false;
        isResizing = false;
        resizeDirection = null;
        document.body.style.userSelect = 'auto';
    });

    document.addEventListener("mousemove", (e) => {
        // Only run if this specific instance is currently active (isDown or isResizing)
        if (isDown && !isResizing) { 
            // --- DRAG LOGIC ---
            let newX = e.clientX - offsetX;
            let newY = e.clientY - offsetY;

            // ... (Drag constraint logic remains the same) ...
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            const popupWidth = popup.offsetWidth;
            
            const minX = -(popupWidth - VISIBLE_HEADER_WIDTH);
            const maxX = viewportWidth - VISIBLE_HEADER_WIDTH; 
            const minY = 0;
            const maxY = viewportHeight - header.offsetHeight; 

            newX = Math.max(minX, Math.min(maxX, newX));
            newY = Math.max(minY, Math.min(maxY, newY));
            
            popup.style.left = newX + "px";
            popup.style.top = newY + "px";

        } else if (isResizing && resizeDirection) {
            // --- RESIZE LOGIC ---
            // ... (Resize calculation logic remains the same) ...
            const dx = e.clientX - offsetX;
            const dy = e.clientY - offsetY;
            
            let newWidth = popup.initialWidth;
            let newHeight = popup.initialHeight;
            let newLeft = popup.initialLeft;
            let newTop = popup.initialTop;

            const direction = resizeDirection;

            // Vertical Resizing
            if (direction.includes('t')) { 
                newHeight = popup.initialHeight - dy;
                newTop = popup.initialTop + dy;
                if (newHeight < MIN_HEIGHT) {
                    newHeight = MIN_HEIGHT;
                    newTop = popup.initialTop + popup.initialHeight - MIN_HEIGHT; 
                }
            } else if (direction.includes('b')) { 
                newHeight = Math.max(MIN_HEIGHT, popup.initialHeight + dy);
            }

            // Horizontal Resizing
            if (direction.includes('l')) { 
                newWidth = popup.initialWidth - dx;
                newLeft = popup.initialLeft + dx;
                if (newWidth < MIN_WIDTH) {
                    newWidth = MIN_WIDTH;
                    newLeft = popup.initialLeft + popup.initialWidth - MIN_WIDTH;
                }
            } else if (direction.includes('r')) { 
                newWidth = Math.max(MIN_WIDTH, popup.initialWidth + dx);
            }

            // Apply Changes
            popup.style.width = newWidth + 'px';
            popup.style.height = newHeight + 'px';
            popup.style.left = newLeft + 'px';
            popup.style.top = newTop + 'px';
        }
    });
}