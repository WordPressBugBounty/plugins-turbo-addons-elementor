/**
 * Turbo Addons - 360 Photo Viewer
 * Simple implementation with HTML markers overlay
 */

(function($) {
    'use strict';

    class Trad360PhotoViewer {
        constructor(container) {
            this.container = container;
            this.$container = $(container);
            this.settings = JSON.parse(this.$container.attr('data-settings'));
            this.imageUrl = this.$container.attr('data-image');
            this.scene = null;
            this.camera = null;
            this.markers = [];

            this.init();
        }

        init() {
            this.createViewer();
            this.setupNavigation();
            this.createHTMLMarkers();
            this.startUpdateLoop();
        }

        createViewer() {
            // Create A-Frame scene
            const sceneHTML = `
                <a-scene embedded vr-mode-ui="enabled: false" device-orientation-permission-ui="enabled: false">
                    <a-sky src="${this.imageUrl}" rotation="0 -130 0"></a-sky>
                    <a-camera look-controls-enabled="true" wasd-controls-enabled="false"></a-camera>
                </a-scene>
            `;

            this.$container.html(sceneHTML);
            this.scene = this.$container.find('a-scene')[0];

            // Wait for scene to load
            if (this.scene) {
                this.scene.addEventListener('loaded', () => {
                    this.$container.removeClass('loading');
                    this.camera = this.scene.querySelector('a-camera');
                    
                    // Reposition VR button based on settings
                    this.repositionVRButton();
                    
                    // Start auto rotation if enabled
                    if (this.settings.autoRotate) {
                        this.startAutoRotate();
                    }
                });
            }
        }

        repositionVRButton() {
            const self = this;
            const $wrapper = this.$container.closest('.trad-360-viewer-wrapper');
            const vrPosition = $wrapper.attr('data-vr-position') || 'bottom-right';
            
            // Wait for VR button to be created by A-Frame
            setTimeout(function() {
                const $vrButton = self.$container.find('.a-enter-vr-button');
                
                if ($vrButton.length) {
                    // Completely remove A-Frame's default SVG icon
                    $vrButton.find('> svg').remove();
                    
                    // Add custom icon if provided
                    if (self.settings.vrButtonIcon && self.settings.vrButtonIcon.value) {
                        let iconHTML = '';
                        
                        if (self.settings.vrButtonIcon.library === 'svg') {
                            iconHTML = self.settings.vrButtonIcon.value;
                        } else {
                            iconHTML = `<i class="${self.settings.vrButtonIcon.value} trad-custom-vr-icon"></i>`;
                        }
                        
                        // Remove any existing custom icon
                        $vrButton.find('.trad-custom-vr-icon').remove();
                        
                        // Add custom icon
                        $vrButton.html(iconHTML);
                    } else {
                        // Default icon if no custom icon
                        $vrButton.find('.trad-custom-vr-icon').remove();
                        $vrButton.html('<i class="icon icon-full-screen trad-custom-vr-icon"></i>');
                    }
                    
                    // Get CSS variables from wrapper
                    const wrapperStyles = window.getComputedStyle($wrapper[0]);
                    const offsetX = wrapperStyles.getPropertyValue('--vr-offset-x') || '20px';
                    const offsetY = wrapperStyles.getPropertyValue('--vr-offset-y') || '20px';
                    
                    // Remove all position styles first
                    $vrButton.css({
                        'top': '',
                        'bottom': '',
                        'left': '',
                        'right': ''
                    });
                    
                    // Apply position based on setting (only bottom positions)
                    if (vrPosition === 'bottom-left') {
                        $vrButton.css({
                            'bottom': offsetY,
                            'left': offsetX,
                            'top': 'auto',
                            'right': 'auto'
                        });
                    } else {
                        // Default: bottom-right
                        $vrButton.css({
                            'bottom': offsetY,
                            'right': offsetX,
                            'top': 'auto',
                            'left': 'auto'
                        });
                    }
                }
            }, 500);
        }

        applyVRButtonStyles($vrButton) {
            // This method is no longer needed as we're using custom icons
        }

        createHTMLMarkers() {
            if (!this.settings.markers || this.settings.markers.length === 0) {
                return;
            }

            const self = this;
            
            this.settings.markers.forEach((marker, index) => {
                // Create HTML marker element
                const $marker = $('<div>', {
                    class: 'trad-360-html-marker',
                    'data-index': index
                });

                // Add icon - handle both string and object format
                let iconHTML = '';
                if (typeof marker.icon === 'string') {
                    iconHTML = `<i class="${marker.icon}"></i>`;
                } else if (marker.icon && marker.icon.value) {
                    // Handle Elementor icon format
                    if (marker.icon.library === 'svg') {
                        iconHTML = marker.icon.value;
                    } else {
                        iconHTML = `<i class="${marker.icon.value}"></i>`;
                    }
                } else {
                    iconHTML = '<i class="fas fa-map-marker-alt"></i>';
                }
                
                $marker.html(iconHTML);

                // Create tooltip
                const $tooltip = $('<div>', {
                    class: 'trad-360-marker-tooltip'
                }).html(`
                    <h4>${marker.title || 'Marker'}</h4>
                    <p>${marker.description || ''}</p>
                `);

                $marker.append($tooltip);

                // Add to container
                this.$container.append($marker);

                // Store marker data
                this.markers.push({
                    element: $marker,
                    position: {
                        x: marker.position.x,
                        y: marker.position.y,
                        z: marker.position.z
                    }
                });

                // Add click event
                $marker.on('click', function(e) {
                    e.stopPropagation();
                    const title = marker.title || 'Marker';
                    const desc = marker.description || '';
                    alert(title + (desc ? '\n\n' + desc : ''));
                });
            });
        }

        startUpdateLoop() {
            const self = this;
            
            function updateMarkerPositions() {
                if (!self.camera || !self.scene) {
                    requestAnimationFrame(updateMarkerPositions);
                    return;
                }

                self.markers.forEach((marker) => {
                    // Get camera rotation
                    const cameraRotation = self.camera.getAttribute('rotation');
                    const cameraYaw = cameraRotation.y;

                    // Calculate marker screen position based on camera rotation
                    const markerYaw = marker.position.x;
                    const markerPitch = marker.position.y;
                    
                    // Normalize angle difference
                    let angleDiff = markerYaw - cameraYaw;
                    while (angleDiff > 180) angleDiff -= 360;
                    while (angleDiff < -180) angleDiff += 360;

                    // Check if marker is in view (within 90 degrees)
                    if (Math.abs(angleDiff) < 90) {
                        // Calculate screen position
                        const containerWidth = self.$container.width();
                        const containerHeight = self.$container.height();
                        
                        const x = containerWidth / 2 + (angleDiff / 90) * (containerWidth / 2);
                        const y = containerHeight / 2 - (markerPitch / 45) * (containerHeight / 2);

                        // Position marker
                        marker.element.css({
                            left: x + 'px',
                            top: y + 'px',
                            display: 'block',
                            opacity: 1 - (Math.abs(angleDiff) / 90) * 0.5
                        });
                    } else {
                        marker.element.css('display', 'none');
                    }
                });

                requestAnimationFrame(updateMarkerPositions);
            }

            updateMarkerPositions();
        }

        startAutoRotate() {
            if (this.camera) {
                this.camera.setAttribute('animation', {
                    property: 'rotation',
                    to: '0 360 0',
                    loop: true,
                    dur: (60 / this.settings.rotationSpeed) * 1000,
                    easing: 'linear'
                });
            }
        }

        stopAutoRotate() {
            if (this.camera) {
                this.camera.removeAttribute('animation');
            }
        }

        setupNavigation() {
            const self = this;
            const $wrapper = this.$container.closest('.trad-360-viewer-wrapper');
            let isRotating = this.settings.autoRotate;

            // Zoom In
            $wrapper.find('.trad-360-zoom-in').on('click', function() {
                if (!self.settings.enableZoom || !self.camera) return;
                const currentFov = self.camera.getAttribute('camera').fov || 80;
                self.camera.setAttribute('camera', 'fov', Math.max(currentFov - 10, 30));
            });

            // Zoom Out
            $wrapper.find('.trad-360-zoom-out').on('click', function() {
                if (!self.settings.enableZoom || !self.camera) return;
                const currentFov = self.camera.getAttribute('camera').fov || 80;
                self.camera.setAttribute('camera', 'fov', Math.min(currentFov + 10, 120));
            });

            // Toggle Rotation
            $wrapper.find('.trad-360-rotate-toggle').on('click', function() {
                if (!self.camera) return;
                
                if (isRotating) {
                    self.stopAutoRotate();
                    $(this).removeClass('active');
                } else {
                    self.startAutoRotate();
                    $(this).addClass('active');
                }
                isRotating = !isRotating;
            });

            // Set initial rotation button state
            if (self.settings.autoRotate) {
                $wrapper.find('.trad-360-rotate-toggle').addClass('active');
            }

            // Fullscreen
            $wrapper.find('.trad-360-fullscreen').on('click', function() {
                if (!self.scene) return;
                
                const elem = self.container;
                if (!document.fullscreenElement) {
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.webkitRequestFullscreen) {
                        elem.webkitRequestFullscreen();
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    }
                    $wrapper.addClass('fullscreen');
                    $(this).find('i').removeClass('fa-expand').addClass('fa-compress');
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                    $wrapper.removeClass('fullscreen');
                    $(this).find('i').removeClass('fa-compress').addClass('fa-expand');
                }
            });

            // Handle fullscreen change events
            $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange msfullscreenchange', function() {
                if (!document.fullscreenElement && !document.webkitFullscreenElement && 
                    !document.mozFullScreenElement && !document.msFullscreenElement) {
                    $wrapper.removeClass('fullscreen');
                    $wrapper.find('.trad-360-fullscreen i').removeClass('fa-compress').addClass('fa-expand');
                    
                    // Force scene resize
                    setTimeout(function() {
                        if (self.scene) {
                            window.dispatchEvent(new Event('resize'));
                        }
                    }, 100);
                }
            });
        }

        destroy() {
            if (this.scene) {
                this.scene.remove();
            }
            this.markers.forEach(marker => marker.element.remove());
        }
    }

    // Initialize on Elementor frontend
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/turbo-360-photo-viewer.default', function($scope) {
            const $container = $scope.find('.trad-360-viewer-container');
            if ($container.length) {
                setTimeout(function() {
                    new Trad360PhotoViewer($container[0]);
                }, 300);
            }
        });
    });

    // Initialize on regular page load
    $(document).ready(function() {
        setTimeout(function() {
            $('.trad-360-viewer-container').each(function() {
                if (!$(this).find('a-scene').length) {
                    new Trad360PhotoViewer(this);
                }
            });
        }, 500);
    });

})(jQuery);
