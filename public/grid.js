/**
 * Create instance of Filterable
 *
 * @param {object}  $container
 * @param {object}   options
 * @constructor
 */
var Grid = function($container, options) {

    /**
     * Default options parameter
     *
     * @type {Object}
     */
    this.options = {
        history: true,
        loadingClass: 'loading',
        fields: 'input.js-grid-input, select.js-grid-input',
        onSuccess: function(result, _me){},
        beforeSend: function(xhr){}
    };

    this.$grid = $container;
    this.options = jQuery.extend(true, this.options, options);

    this._listener();
};

/**
 * All filterable listener
 *
 * @private
 */
Grid.prototype = {

    _listener: function () {
        var _me = this;

        /* Revert to a previously saved state, if back or forward */
        window.addEventListener('popstate', function () {
            if (_me.options.history && 'history' in window && 'pushState' in history) {
                _me.update(document.URL);
            }
        });

        // update listing when select, checkbox, radio
        this.$grid.delegate('.js-grid-filter-input, .js-grid-filter-radio input, .js-grid-filter-checkbox input', 'change', function (e) {
            e.preventDefault();
            _me.update(null);
        });

        // update listing from pagination anchor element, or when click on link
        this.$grid.delegate('.pagination li a:not(.disabled), .js-grid-filter', 'click', function (e) {
            e.preventDefault();
            _me.update($(this));
        });

        // submit
        this.$grid.delegate('.js-grid-submit', 'click', function (e) {
            e.preventDefault();
            _me.update();
        });
    },

    /**
     * Update listing
     *
     * @param $el
     */
    update: function($el) {
        var _me = this;
        var url = this.generateUrl($el);

        ! this.cXhr || this.cXhr.abort();

        this.cXhr = $.ajax({
            type: 'GET',
            url: url,
            datType: 'JSON',
            success: function(data) {
                if (data.status == 'success') {
                    // update listing result
                    for (var x in data.replace) {
                        _me.$grid.find('.'+x).replaceWith(data.replace[x]);
                    }
                    _me.options.onSuccess(data, _me);
                }
            },
            beforeSend: function(xhr) {
                _me.$grid.addClass(_me.options.loadingClass);
                _me.options.beforeSend(xhr);
            }
        }).done(function () {
            _me.$grid.removeClass(_me.options.loadingClass);
        });
    },

    /**
     * Get serialized form not including empty
     *
     * @returns {string}
     */
    serializeFields: function() {
        return this.$grid.find(this.options.fields).filter(function(index, element) {
            // do not include if the element value is null
            return $(element).val() != "";
        }).serialize();
    },

    /**
     * Get the element target uri
     *
     * @param {object} $el   - if null, then use form action as url and do serialize as data
     * @return {string}
     */
    generateUrl: function ($el) {
        var url = '';
        var serializeFields = false;
        if ($el == null) {
            url = this.$grid.data('grid-url');
            serializeFields = true;
        } else if (typeof $el === 'string') {
            url = $el;
        } else {
            var targetUrl = $el.data('target-url');
            if (typeof targetUrl !== 'undefined' && targetUrl !== '') {
                url = targetUrl;
            } else {
                url = $el.attr('href')
            }
        }

        var fpo = url.indexOf('#');
        var fragment = (fpo === -1) ? '' : url.substr(fpo);

        // remove url fragment
        url = (fragment == '') ? url : url.substr(0, fpo);

        if (serializeFields) {
            url += this.urlSeparator(url) + this.serializeFields();
        }

        // add url to history
        this.history(url + fragment);

        // append ajax field
        url += this.urlSeparator(url) + 'ajax=1';

        return url;
    },

    /**
     * Update history location browser
     *
     * @param {string} url
     */
    history: function(url) {
        if( this.options.history && 'history' in window && 'pushState' in history ) {
            // only push to history if flag as true and browser supports history pushState
            if (history.pathname !== url) {
                history.pushState({ url: url }, "Grid", url);
                history.pathname = url;
            }
        }
    },

    urlSeparator: function(url) {
        return (url.indexOf('?') === -1) ? '?' : '&';
    }
};
