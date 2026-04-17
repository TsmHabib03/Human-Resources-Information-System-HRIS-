(function () {
    if (document.body && window.requestAnimationFrame) {
        window.requestAnimationFrame(function () {
            document.body.classList.add('mk-ready');
        });
    } else if (document.body) {
        document.body.classList.add('mk-ready');
    }

    var planPickers = document.querySelectorAll('[data-plan-picker]');
    if (!planPickers || planPickers.length === 0) {
        return;
    }

    planPickers.forEach(function (picker) {
        var cards = Array.prototype.slice.call(picker.querySelectorAll('[data-plan-card]'));
        if (!cards || cards.length === 0) {
            return;
        }

        var liveRegion = picker.querySelector('.mk-live-region, .bill-live-region');
        var summaryPlan = picker.querySelector('[data-selection-plan]');
        var submitButton = picker.querySelector('button[type="submit"]');
        var isSubmitting = false;

        var cardRadio = function (card) {
            return card.querySelector('input[type="radio"][name="plan_id"]');
        };

        var selectCardByIndex = function (index, moveFocus) {
            if (!cards[index]) {
                return;
            }

            var radio = cardRadio(cards[index]);
            if (!radio) {
                return;
            }

            radio.checked = true;
            setSelectedState(true);

            if (moveFocus) {
                cards[index].focus();
            }
        };

        var setSelectedState = function (announceSelection) {
            var selectedPlanName = '';

            cards.forEach(function (card) {
                var radio = cardRadio(card);
                var selected = !!radio && radio.checked;

                card.classList.toggle('is-selected', selected);
                card.setAttribute('data-selected', selected ? 'true' : 'false');
                card.setAttribute('aria-checked', selected ? 'true' : 'false');

                if (selected) {
                    selectedPlanName = card.getAttribute('data-plan-name') || '';
                }
            });

            if (summaryPlan) {
                summaryPlan.textContent = selectedPlanName || 'No plan selected';
            }

            if (announceSelection && liveRegion) {
                liveRegion.textContent = selectedPlanName
                    ? selectedPlanName + ' selected.'
                    : 'No plan selected.';
            }
        };

        cards.forEach(function (card, index) {
            var radio = cardRadio(card);
            if (!radio) {
                return;
            }

            card.setAttribute('tabindex', '0');
            card.setAttribute('role', 'radio');

            card.addEventListener('click', function () {
                if (!radio.checked) {
                    radio.checked = true;
                }

                setSelectedState(true);
            });

            card.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    radio.checked = true;
                    setSelectedState(true);
                    return;
                }

                if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
                    event.preventDefault();
                    selectCardByIndex((index + 1) % cards.length, true);
                    return;
                }

                if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
                    event.preventDefault();
                    selectCardByIndex((index - 1 + cards.length) % cards.length, true);
                }
            });

            radio.addEventListener('change', function () {
                setSelectedState(true);
            });
        });

        picker.addEventListener('submit', function (event) {
            if (isSubmitting) {
                event.preventDefault();
                return;
            }

            var selected = picker.querySelector('input[type="radio"][name="plan_id"]:checked');
            if (!selected) {
                var firstRadio = picker.querySelector('input[type="radio"][name="plan_id"]');
                if (firstRadio) {
                    firstRadio.checked = true;
                    setSelectedState(true);
                    selected = firstRadio;
                }
            }

            if (!selected || !submitButton) {
                return;
            }

            isSubmitting = true;
            submitButton.disabled = true;
            submitButton.textContent = submitButton.getAttribute('data-loading-label') || 'Processing...';
        });

        if (submitButton && submitButton.getAttribute('data-submit-label')) {
            submitButton.textContent = submitButton.getAttribute('data-submit-label');
        }

        setSelectedState(false);
    });
})();
