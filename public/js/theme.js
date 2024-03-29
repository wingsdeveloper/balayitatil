!(function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? (module.exports = t()) : "function" == typeof define && define.amd ? define(t) : (e.Popper = t());
})(this, function () {
    "use strict";
    function s(e) {
        return e && "[object Function]" === {}.toString.call(e);
    }
    function u(e, t) {
        if (1 !== e.nodeType) return [];
        e = window.getComputedStyle(e, null);
        return t ? e[t] : e;
    }
    function h(e) {
        return "HTML" === e.nodeName ? e : e.parentNode || e.host;
    }
    function p(e) {
        if (!e || -1 !== ["HTML", "BODY", "#document"].indexOf(e.nodeName)) return window.document.body;
        var t = u(e),
            i = t.overflow,
            n = t.overflowX,
            t = t.overflowY;
        return /(auto|scroll)/.test(i + t + n) ? e : p(h(e));
    }
    function d(e) {
        var t = e && e.offsetParent,
            e = t && t.nodeName;
        return e && "BODY" !== e && "HTML" !== e ? (-1 !== ["TD", "TABLE"].indexOf(t.nodeName) && "static" === u(t, "position") ? d(t) : t) : window.document.documentElement;
    }
    function a(e) {
        return null === e.parentNode ? e : a(e.parentNode);
    }
    function f(e, t) {
        if (!(e && e.nodeType && t && t.nodeType)) return window.document.documentElement;
        var i = e.compareDocumentPosition(t) & Node.DOCUMENT_POSITION_FOLLOWING,
            n = i ? e : t,
            s = i ? t : e,
            i = document.createRange();
        i.setStart(n, 0), i.setEnd(s, 0);
        i = i.commonAncestorContainer;
        if ((e !== i && t !== i) || n.contains(s)) return "BODY" === (s = (n = i).nodeName) || ("HTML" !== s && d(n.firstElementChild) !== n) ? d(i) : i;
        i = a(e);
        return i.host ? f(i.host, t) : f(e, a(t).host);
    }
    function m(e, t) {
        var i = "top" === (1 < arguments.length && void 0 !== t ? t : "top") ? "scrollTop" : "scrollLeft",
            t = e.nodeName;
        if ("BODY" !== t && "HTML" !== t) return e[i];
        e = window.document.documentElement;
        return (window.document.scrollingElement || e)[i];
    }
    function l(e, t) {
        var i = "x" === t ? "Left" : "Top",
            t = "Left" == i ? "Right" : "Bottom";
        return +e["border" + i + "Width"].split("px")[0] + +e["border" + t + "Width"].split("px")[0];
    }
    function n(e, t, i, n) {
        return P(t["offset" + e], t["scroll" + e], i["client" + e], i["offset" + e], i["scroll" + e], F() ? i["offset" + e] + n["margin" + ("Height" === e ? "Top" : "Left")] + n["margin" + ("Height" === e ? "Bottom" : "Right")] : 0);
    }
    function v() {
        var e = window.document.body,
            t = window.document.documentElement,
            i = F() && window.getComputedStyle(t);
        return { height: n("Height", e, t, i), width: n("Width", e, t, i) };
    }
    function g(e) {
        return U({}, e, { right: e.left + e.width, bottom: e.top + e.height });
    }
    function c(e) {
        var t = {};
        if (F())
            try {
                t = e.getBoundingClientRect();
                var i = m(e, "top"),
                    n = m(e, "left");
                (t.top += i), (t.left += n), (t.bottom += i), (t.right += n);
            } catch (e) {}
        else t = e.getBoundingClientRect();
        var s = { left: t.left, top: t.top, width: t.right - t.left, height: t.bottom - t.top },
            a = "HTML" === e.nodeName ? v() : {},
            o = a.width || e.clientWidth || s.right - s.left,
            r = a.height || e.clientHeight || s.bottom - s.top,
            a = e.offsetWidth - o,
            o = e.offsetHeight - r;
        return (a || o) && ((a -= l((r = u(e)), "x")), (o -= l(r, "y")), (s.width -= a), (s.height -= o)), g(s);
    }
    function w(e, t) {
        var i = F(),
            n = "HTML" === t.nodeName,
            s = c(e),
            a = c(t),
            o = p(e),
            r = u(t),
            l = +r.borderTopWidth.split("px")[0],
            e = +r.borderLeftWidth.split("px")[0],
            s = g({ top: s.top - a.top - l, left: s.left - a.left - e, width: s.width, height: s.height });
        return (
            (s.marginTop = 0),
                (s.marginLeft = 0),
            !i && n && ((n = +r.marginTop.split("px")[0]), (r = +r.marginLeft.split("px")[0]), (s.top -= l - n), (s.bottom -= l - n), (s.left -= e - r), (s.right -= e - r), (s.marginTop = n), (s.marginLeft = r)),
            (i ? t.contains(o) : t === o && "BODY" !== o.nodeName) &&
            (s = (function (e, t, i) {
                var n = 2 < arguments.length && void 0 !== i && i,
                    i = m(t, "top"),
                    t = m(t, "left"),
                    n = n ? -1 : 1;
                return (e.top += i * n), (e.bottom += i * n), (e.left += t * n), (e.right += t * n), e;
            })(s, t)),
                s
        );
    }
    function r(e, t, i, n) {
        var s,
            a,
            o,
            r,
            l,
            d = { top: 0, left: 0 },
            c = f(e, t);
        return (
            "viewport" === n
                ? ((a = c),
                    (o = window.document.documentElement),
                    (r = w(a, o)),
                    (l = P(o.clientWidth, window.innerWidth || 0)),
                    (t = P(o.clientHeight, window.innerHeight || 0)),
                    (a = m(o)),
                    (o = m(o, "left")),
                    (d = g({ top: a - r.top + r.marginTop, left: o - r.left + r.marginLeft, width: l, height: t })))
                : ("scrollParent" === n ? "BODY" === (s = p(h(e))).nodeName && (s = window.document.documentElement) : (s = "window" === n ? window.document.documentElement : n),
                    (n = w(s, c)),
                    "HTML" !== s.nodeName ||
                    (function e(t) {
                        var i = t.nodeName;
                        return "BODY" !== i && "HTML" !== i && ("fixed" === u(t, "position") || e(h(t)));
                    })(c)
                        ? (d = n)
                        : ((c = (s = v()).height), (s = s.width), (d.top += n.top - n.marginTop), (d.bottom = c + n.top), (d.left += n.left - n.marginLeft), (d.right = s + n.left))),
                (d.left += i),
                (d.top += i),
                (d.right -= i),
                (d.bottom -= i),
                d
        );
    }
    function o(e, t, i, n, s, a) {
        a = 5 < arguments.length && void 0 !== a ? a : 0;
        if (-1 === e.indexOf("auto")) return e;
        var s = r(i, n, a, s),
            o = { top: { width: s.width, height: t.top - s.top }, right: { width: s.right - t.right, height: s.height }, bottom: { width: s.width, height: s.bottom - t.bottom }, left: { width: t.left - s.left, height: s.height } },
            t = Object.keys(o)
                .map(function (e) {
                    return U({ key: e }, o[e], { area: (e = o[e]).width * e.height });
                })
                .sort(function (e, t) {
                    return t.area - e.area;
                }),
            s = t.filter(function (e) {
                var t = e.width,
                    e = e.height;
                return t >= i.clientWidth && e >= i.clientHeight;
            }),
            t = (0 < s.length ? s : t)[0].key,
            e = e.split("-")[1];
        return t + (e ? "-" + e : "");
    }
    function y(e, t, i) {
        return w(i, f(t, i));
    }
    function b(e) {
        var t = window.getComputedStyle(e),
            i = parseFloat(t.marginTop) + parseFloat(t.marginBottom),
            t = parseFloat(t.marginLeft) + parseFloat(t.marginRight);
        return { width: e.offsetWidth + t, height: e.offsetHeight + i };
    }
    function _(e) {
        var t = { left: "right", right: "left", bottom: "top", top: "bottom" };
        return e.replace(/left|right|bottom|top/g, function (e) {
            return t[e];
        });
    }
    function k(e, t, i) {
        i = i.split("-")[0];
        var n = b(e),
            s = { width: n.width, height: n.height },
            a = -1 !== ["right", "left"].indexOf(i),
            o = a ? "top" : "left",
            r = a ? "left" : "top",
            e = a ? "height" : "width",
            a = a ? "width" : "height";
        return (s[o] = t[o] + t[e] / 2 - n[e] / 2), (s[r] = i === r ? t[r] - n[a] : t[_(r)]), s;
    }
    function x(e, t) {
        return Array.prototype.find ? e.find(t) : e.filter(t)[0];
    }
    function C(e, i, t) {
        return (
            (void 0 === t
                    ? e
                    : e.slice(
                        0,
                        (function (e, t, i) {
                            if (Array.prototype.findIndex)
                                return e.findIndex(function (e) {
                                    return e[t] === i;
                                });
                            var n = x(e, function (e) {
                                return e[t] === i;
                            });
                            return e.indexOf(n);
                        })(e, "name", t)
                    )
            ).forEach(function (e) {
                e.function && console.warn("`modifier.function` is deprecated, use `modifier.fn`!");
                var t = e.function || e.fn;
                e.enabled && s(t) && ((i.offsets.popper = g(i.offsets.popper)), (i.offsets.reference = g(i.offsets.reference)), (i = t(i, e)));
            }),
                i
        );
    }
    function e(e, i) {
        return e.some(function (e) {
            var t = e.name;
            return e.enabled && t === i;
        });
    }
    function S(e) {
        for (var t = [!1, "ms", "Webkit", "Moz", "O"], i = e.charAt(0).toUpperCase() + e.slice(1), n = 0; n < t.length - 1; n++) {
            var s = t[n],
                s = s ? "" + s + i : e;
            if (void 0 !== window.document.body.style[s]) return s;
        }
        return null;
    }
    function t(e, t, i, n) {
        (i.updateBound = n), window.addEventListener("resize", i.updateBound, { passive: !0 });
        e = p(e);
        return (
            (function e(t, i, n, s) {
                var a = "BODY" === t.nodeName,
                    t = a ? window : t;
                t.addEventListener(i, n, { passive: !0 }), a || e(p(t.parentNode), i, n, s), s.push(t);
            })(e, "scroll", i.updateBound, i.scrollParents),
                (i.scrollElement = e),
                (i.eventsEnabled = !0),
                i
        );
    }
    function i() {
        var t;
        this.state.eventsEnabled &&
        (window.cancelAnimationFrame(this.scheduleUpdate),
            (this.state =
                (this.reference,
                    (t = this.state),
                    window.removeEventListener("resize", t.updateBound),
                    t.scrollParents.forEach(function (e) {
                        e.removeEventListener("scroll", t.updateBound);
                    }),
                    (t.updateBound = null),
                    (t.scrollParents = []),
                    (t.scrollElement = null),
                    (t.eventsEnabled = !1),
                    t)));
    }
    function T(e) {
        return "" !== e && !isNaN(parseFloat(e)) && isFinite(e);
    }
    function $(i, n) {
        Object.keys(n).forEach(function (e) {
            var t = "";
            -1 !== ["width", "height", "top", "right", "bottom", "left"].indexOf(e) && T(n[e]) && (t = "px"), (i.style[e] = n[e] + t);
        });
    }
    function E(e, t, i) {
        var n = x(e, function (e) {
                return e.name === t;
            }),
            s =
                !!n &&
                e.some(function (e) {
                    return e.name === i && e.enabled && e.order < n.order;
                });
        return s || ((e = "`" + t + "`"), console.warn("`" + i + "` modifier is required by " + e + " modifier in order to work, be sure to include it before " + e + "!")), s;
    }
    function D(e, t) {
        (t = 1 < arguments.length && void 0 !== t && t), (e = q.indexOf(e)), (e = q.slice(e + 1).concat(q.slice(0, e)));
        return t ? e.reverse() : e;
    }
    function M(e, s, a, t) {
        var o = [0, 0],
            r = -1 !== ["right", "left"].indexOf(t),
            i = e.split(/(\+|\-)/).map(function (e) {
                return e.trim();
            }),
            t = i.indexOf(
                x(i, function (e) {
                    return -1 !== e.search(/,|\s/);
                })
            );
        i[t] && -1 === i[t].indexOf(",") && console.warn("Offsets separated by white space(s) are deprecated, use a comma (,) instead.");
        e = /\s*,\s*|\s+/;
        return (
            (-1 === t ? [i] : [i.slice(0, t).concat([i[t].split(e)[0]]), [i[t].split(e)[1]].concat(i.slice(t + 1))])
                .map(function (e, t) {
                    var i = (1 === t ? !r : r) ? "height" : "width",
                        n = !1;
                    return e
                        .reduce(function (e, t) {
                            return "" === e[e.length - 1] && -1 !== ["+", "-"].indexOf(t) ? ((e[e.length - 1] = t), (n = !0), e) : n ? ((e[e.length - 1] += t), (n = !1), e) : e.concat(t);
                        }, [])
                        .map(function (e) {
                            return (function (e, t, i, n) {
                                var s,
                                    a = +(o = e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/))[1],
                                    o = o[2];
                                if (!a) return e;
                                if (0 !== o.indexOf("%"))
                                    return "vh" !== o && "vw" !== o ? a : (("vh" === o ? P(document.documentElement.clientHeight, window.innerHeight || 0) : P(document.documentElement.clientWidth, window.innerWidth || 0)) / 100) * a;
                                switch (o) {
                                    case "%p":
                                        s = i;
                                        break;
                                    case "%":
                                    case "%r":
                                    default:
                                        s = n;
                                }
                                return (g(s)[t] / 100) * a;
                            })(e, i, s, a);
                        });
                })
                .forEach(function (i, n) {
                    i.forEach(function (e, t) {
                        T(e) && (o[n] += e * ("-" === i[t - 1] ? -1 : 1));
                    });
                }),
                o
        );
    }
    for (var O = Math.min, I = Math.floor, P = Math.max, A = ["native code", "[object MutationObserverConstructor]"], z = "undefined" != typeof window, L = ["Edge", "Trident", "Firefox"], W = 0, N = 0; N < L.length; N += 1)
        if (z && 0 <= navigator.userAgent.indexOf(L[N])) {
            W = 1;
            break;
        }
    function Y(e, t, i) {
        return t in e ? Object.defineProperty(e, t, { value: i, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = i), e;
    }
    var j,
        H,
        R =
            z &&
            ((H = window.MutationObserver),
                A.some(function (e) {
                    return -1 < (H || "").toString().indexOf(e);
                }))
                ? function (e) {
                    var t = !1,
                        i = 0,
                        n = document.createElement("span");
                    return (
                        new MutationObserver(function () {
                            e(), (t = !1);
                        }).observe(n, { attributes: !0 }),
                            function () {
                                t || ((t = !0), n.setAttribute("x-index", i), ++i);
                            }
                    );
                }
                : function (e) {
                    var t = !1;
                    return function () {
                        t ||
                        ((t = !0),
                            setTimeout(function () {
                                (t = !1), e();
                            }, W));
                    };
                },
        F = function () {
            return null == j && (j = -1 !== navigator.appVersion.indexOf("MSIE 10")), j;
        },
        B = function (e, t) {
            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
        },
        V = function (e, t, i) {
            return t && J(e.prototype, t), i && J(e, i), e;
        },
        U =
            Object.assign ||
            function (e) {
                for (var t, i = 1; i < arguments.length; i++) for (var n in (t = arguments[i])) Object.prototype.hasOwnProperty.call(t, n) && (e[n] = t[n]);
                return e;
            },
        G = ["auto-start", "auto", "auto-end", "top-start", "top", "top-end", "right-start", "right", "right-end", "bottom-end", "bottom", "bottom-start", "left-end", "left", "left-start"],
        q = G.slice(3),
        X = "flip",
        Z = "clockwise",
        K = "counterclockwise",
        V =
            (V(Q, [
                {
                    key: "update",
                    value: function () {
                        return function () {
                            var e;
                            this.state.isDestroyed ||
                            (((e = { instance: this, styles: {}, arrowStyles: {}, attributes: {}, flipped: !1, offsets: {} }).offsets.reference = y(this.state, this.popper, this.reference)),
                                (e.placement = o(this.options.placement, e.offsets.reference, this.popper, this.reference, this.options.modifiers.flip.boundariesElement, this.options.modifiers.flip.padding)),
                                (e.originalPlacement = e.placement),
                                (e.offsets.popper = k(this.popper, e.offsets.reference, e.placement)),
                                (e.offsets.popper.position = "absolute"),
                                (e = C(this.modifiers, e)),
                                this.state.isCreated ? this.options.onUpdate(e) : ((this.state.isCreated = !0), this.options.onCreate(e)));
                        }.call(this);
                    },
                },
                {
                    key: "destroy",
                    value: function () {
                        return function () {
                            return (
                                (this.state.isDestroyed = !0),
                                e(this.modifiers, "applyStyle") &&
                                (this.popper.removeAttribute("x-placement"), (this.popper.style.left = ""), (this.popper.style.position = ""), (this.popper.style.top = ""), (this.popper.style[S("transform")] = "")),
                                    this.disableEventListeners(),
                                this.options.removeOnDestroy && this.popper.parentNode.removeChild(this.popper),
                                    this
                            );
                        }.call(this);
                    },
                },
                {
                    key: "enableEventListeners",
                    value: function () {
                        return function () {
                            this.state.eventsEnabled || (this.state = t(this.reference, this.options, this.state, this.scheduleUpdate));
                        }.call(this);
                    },
                },
                {
                    key: "disableEventListeners",
                    value: function () {
                        return i.call(this);
                    },
                },
            ]),
                Q);
    function Q(e, t) {
        var i = this,
            n = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : {};
        B(this, Q),
            (this.scheduleUpdate = function () {
                return requestAnimationFrame(i.update);
            }),
            (this.update = R(this.update.bind(this))),
            (this.options = U({}, Q.Defaults, n)),
            (this.state = { isDestroyed: !1, isCreated: !1, scrollParents: [] }),
            (this.reference = e.jquery ? e[0] : e),
            (this.popper = t.jquery ? t[0] : t),
            (this.options.modifiers = {}),
            Object.keys(U({}, Q.Defaults.modifiers, n.modifiers)).forEach(function (e) {
                i.options.modifiers[e] = U({}, Q.Defaults.modifiers[e] || {}, n.modifiers ? n.modifiers[e] : {});
            }),
            (this.modifiers = Object.keys(this.options.modifiers)
                .map(function (e) {
                    return U({ name: e }, i.options.modifiers[e]);
                })
                .sort(function (e, t) {
                    return e.order - t.order;
                })),
            this.modifiers.forEach(function (e) {
                e.enabled && s(e.onLoad) && e.onLoad(i.reference, i.popper, i.options, e, i.state);
            }),
            this.update();
        t = this.options.eventsEnabled;
        t && this.enableEventListeners(), (this.state.eventsEnabled = t);
    }
    function J(e, t) {
        for (var i, n = 0; n < t.length; n++) ((i = t[n]).enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
    }
    return (
        (V.Utils = ("undefined" == typeof window ? global : window).PopperUtils),
            (V.placements = G),
            (V.Defaults = {
                placement: "bottom",
                eventsEnabled: !0,
                removeOnDestroy: !1,
                onCreate: function () {},
                onUpdate: function () {},
                modifiers: {
                    shift: {
                        order: 100,
                        enabled: !0,
                        fn: function (e) {
                            var t,
                                i,
                                n = e.placement,
                                s = n.split("-")[0],
                                a = n.split("-")[1];
                            return (
                                a &&
                                ((t = (i = e.offsets).reference),
                                    (n = i.popper),
                                    (s = (i = -1 !== ["bottom", "top"].indexOf(s)) ? "width" : "height"),
                                    (s = { start: Y({}, (i = i ? "left" : "top"), t[i]), end: Y({}, i, t[i] + t[s] - n[s]) }),
                                    (e.offsets.popper = U({}, n, s[a]))),
                                    e
                            );
                        },
                    },
                    offset: {
                        order: 200,
                        enabled: !0,
                        fn: function (e, t) {
                            var i = t.offset,
                                n = e.placement,
                                t = (s = e.offsets).popper,
                                s = s.reference,
                                n = n.split("-")[0],
                                s = T(+i) ? [+i, 0] : M(i, t, s, n);
                            return (
                                "left" === n
                                    ? ((t.top += s[0]), (t.left -= s[1]))
                                    : "right" === n
                                        ? ((t.top += s[0]), (t.left += s[1]))
                                        : "top" === n
                                            ? ((t.left += s[0]), (t.top -= s[1]))
                                            : "bottom" === n && ((t.left += s[0]), (t.top += s[1])),
                                    (e.popper = t),
                                    e
                            );
                        },
                        offset: 0,
                    },
                    preventOverflow: {
                        order: 300,
                        enabled: !0,
                        fn: function (e, n) {
                            var t = n.boundariesElement || d(e.instance.popper);
                            e.instance.reference === t && (t = d(t));
                            var s = r(e.instance.popper, e.instance.reference, n.padding, t);
                            n.boundaries = s;
                            var t = n.priority,
                                a = e.offsets.popper,
                                i = {
                                    primary: function (e) {
                                        var t = a[e];
                                        return a[e] < s[e] && !n.escapeWithReference && (t = P(a[e], s[e])), Y({}, e, t);
                                    },
                                    secondary: function (e) {
                                        var t = "right" === e ? "left" : "top",
                                            i = a[t];
                                        return a[e] > s[e] && !n.escapeWithReference && (i = O(a[t], s[e] - ("right" === e ? a.width : a.height))), Y({}, t, i);
                                    },
                                };
                            return (
                                t.forEach(function (e) {
                                    var t = -1 === ["left", "top"].indexOf(e) ? "secondary" : "primary";
                                    a = U({}, a, i[t](e));
                                }),
                                    (e.offsets.popper = a),
                                    e
                            );
                        },
                        priority: ["left", "right", "top", "bottom"],
                        padding: 5,
                        boundariesElement: "scrollParent",
                    },
                    keepTogether: {
                        order: 400,
                        enabled: !0,
                        fn: function (e) {
                            var t = e.offsets,
                                i = t.popper,
                                n = t.reference,
                                s = e.placement.split("-")[0],
                                a = I,
                                o = -1 !== ["top", "bottom"].indexOf(s),
                                t = o ? "right" : "bottom",
                                s = o ? "left" : "top",
                                o = o ? "width" : "height";
                            return i[t] < a(n[s]) && (e.offsets.popper[s] = a(n[s]) - i[o]), i[s] > a(n[t]) && (e.offsets.popper[s] = a(n[t])), e;
                        },
                    },
                    arrow: {
                        order: 500,
                        enabled: !0,
                        fn: function (e, t) {
                            if (!E(e.instance.modifiers, "arrow", "keepTogether")) return e;
                            var i = t.element;
                            if ("string" == typeof i) {
                                if (!(i = e.instance.popper.querySelector(i))) return e;
                            } else if (!e.instance.popper.contains(i)) return console.warn("WARNING: `arrow.element` must be child of its popper element!"), e;
                            var n = e.placement.split("-")[0],
                                s = e.offsets,
                                a = s.popper,
                                o = s.reference,
                                r = -1 !== ["left", "right"].indexOf(n),
                                l = r ? "height" : "width",
                                d = r ? "Top" : "Left",
                                t = d.toLowerCase(),
                                s = r ? "left" : "top",
                                n = r ? "bottom" : "right",
                                r = b(i)[l];
                            o[n] - r < a[t] && (e.offsets.popper[t] -= a[t] - (o[n] - r)), o[t] + r > a[n] && (e.offsets.popper[t] += o[t] + r - a[n]);
                            (o = o[t] + o[l] / 2 - r / 2), (d = u(e.instance.popper, "margin" + d).replace("px", "")), (d = o - g(e.offsets.popper)[t] - d), (d = P(O(a[l] - r, d), 0));
                            return (e.arrowElement = i), (e.offsets.arrow = {}), (e.offsets.arrow[t] = Math.round(d)), (e.offsets.arrow[s] = ""), e;
                        },
                        element: "[x-arrow]",
                    },
                    flip: {
                        order: 600,
                        enabled: !0,
                        fn: function (l, d) {
                            if (e(l.instance.modifiers, "inner")) return l;
                            if (l.flipped && l.placement === l.originalPlacement) return l;
                            var c = r(l.instance.popper, l.instance.reference, d.padding, d.boundariesElement),
                                u = l.placement.split("-")[0],
                                h = _(u),
                                p = l.placement.split("-")[1] || "",
                                f = [];
                            switch (d.behavior) {
                                case X:
                                    f = [u, h];
                                    break;
                                case Z:
                                    f = D(u);
                                    break;
                                case K:
                                    f = D(u, !0);
                                    break;
                                default:
                                    f = d.behavior;
                            }
                            return (
                                f.forEach(function (e, t) {
                                    if (u !== e || f.length === t + 1) return l;
                                    (u = l.placement.split("-")[0]), (h = _(u));
                                    var i = l.offsets.popper,
                                        n = l.offsets.reference,
                                        s = I,
                                        a = ("left" === u && s(i.right) > s(n.left)) || ("right" === u && s(i.left) < s(n.right)) || ("top" === u && s(i.bottom) > s(n.top)) || ("bottom" === u && s(i.top) < s(n.bottom)),
                                        o = s(i.left) < s(c.left),
                                        r = s(i.right) > s(c.right),
                                        e = s(i.top) < s(c.top),
                                        n = s(i.bottom) > s(c.bottom),
                                        i = ("left" === u && o) || ("right" === u && r) || ("top" === u && e) || ("bottom" === u && n),
                                        s = -1 !== ["top", "bottom"].indexOf(u),
                                        n = !!d.flipVariations && ((s && "start" === p && o) || (s && "end" === p && r) || (!s && "start" === p && e) || (!s && "end" === p && n));
                                    (a || i || n) &&
                                    ((l.flipped = !0),
                                    (a || i) && (u = f[t + 1]),
                                    n && (p = "end" === (n = p) ? "start" : "start" === n ? "end" : n),
                                        (l.placement = u + (p ? "-" + p : "")),
                                        (l.offsets.popper = U({}, l.offsets.popper, k(l.instance.popper, l.offsets.reference, l.placement))),
                                        (l = C(l.instance.modifiers, l, "flip")));
                                }),
                                    l
                            );
                        },
                        behavior: "flip",
                        padding: 5,
                        boundariesElement: "viewport",
                    },
                    inner: {
                        order: 700,
                        enabled: !1,
                        fn: function (e) {
                            var t = e.placement,
                                i = t.split("-")[0],
                                n = e.offsets,
                                s = n.popper,
                                a = n.reference,
                                o = -1 !== ["left", "right"].indexOf(i),
                                n = -1 === ["top", "left"].indexOf(i);
                            return (s[o ? "left" : "top"] = a[i] - (n ? s[o ? "width" : "height"] : 0)), (e.placement = _(t)), (e.offsets.popper = g(s)), e;
                        },
                    },
                    hide: {
                        order: 800,
                        enabled: !0,
                        fn: function (e) {
                            if (!E(e.instance.modifiers, "hide", "preventOverflow")) return e;
                            var t = e.offsets.reference,
                                i = x(e.instance.modifiers, function (e) {
                                    return "preventOverflow" === e.name;
                                }).boundaries;
                            if (t.bottom < i.top || t.left > i.right || t.top > i.bottom || t.right < i.left) {
                                if (!0 === e.hide) return e;
                                (e.hide = !0), (e.attributes["x-out-of-boundaries"] = "");
                            } else {
                                if (!1 === e.hide) return e;
                                (e.hide = !1), (e.attributes["x-out-of-boundaries"] = !1);
                            }
                            return e;
                        },
                    },
                    computeStyle: {
                        order: 850,
                        enabled: !0,
                        fn: function (e, t) {
                            var i = t.x,
                                n = t.y,
                                s = e.offsets.popper,
                                a = x(e.instance.modifiers, function (e) {
                                    return "applyStyle" === e.name;
                                }).gpuAcceleration;
                            void 0 !== a && console.warn("WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!");
                            var o = void 0 === a ? t.gpuAcceleration : a,
                                r = c(d(e.instance.popper)),
                                l = { position: s.position },
                                t = { left: I(s.left), top: I(s.top), bottom: I(s.bottom), right: I(s.right) },
                                a = "bottom" === i ? "top" : "bottom",
                                s = "right" === n ? "left" : "right",
                                i = S("transform"),
                                n = "bottom" == a ? -r.height + t.bottom : t.top,
                                t = "right" == s ? -r.width + t.right : t.left;
                            o && i
                                ? ((l[i] = "translate3d(" + t + "px, " + n + "px, 0)"), (l[a] = 0), (l[s] = 0), (l.willChange = "transform"))
                                : ((o = "bottom" == a ? -1 : 1), (i = "right" == s ? -1 : 1), (l[a] = n * o), (l[s] = t * i), (l.willChange = a + ", " + s));
                            s = { "x-placement": e.placement };
                            return (e.attributes = U({}, s, e.attributes)), (e.styles = U({}, l, e.styles)), (e.arrowStyles = U({}, e.offsets.arrow, e.arrowStyles)), e;
                        },
                        gpuAcceleration: !0,
                        x: "bottom",
                        y: "right",
                    },
                    applyStyle: {
                        order: 900,
                        enabled: !0,
                        fn: function (e) {
                            return (
                                $(e.instance.popper, e.styles),
                                    (t = e.instance.popper),
                                    (i = e.attributes),
                                    Object.keys(i).forEach(function (e) {
                                        !1 === i[e] ? t.removeAttribute(e) : t.setAttribute(e, i[e]);
                                    }),
                                e.arrowElement && Object.keys(e.arrowStyles).length && $(e.arrowElement, e.arrowStyles),
                                    e
                            );
                            var t, i;
                        },
                        onLoad: function (e, t, i, n, s) {
                            var a = y(0, t, e),
                                e = o(i.placement, a, t, e, i.modifiers.flip.boundariesElement, i.modifiers.flip.padding);
                            return t.setAttribute("x-placement", e), $(t, { position: "absolute" }), i;
                        },
                        gpuAcceleration: void 0,
                    },
                },
            }),
            V
    );
});
var bootstrap = (function (e, D, S) {
    "use strict";
    function n(e, t) {
        for (var i = 0; i < t.length; i++) {
            var n = t[i];
            (n.enumerable = n.enumerable || !1), (n.configurable = !0), "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n);
        }
    }
    (D = D && D.hasOwnProperty("default") ? D.default : D), (S = S && S.hasOwnProperty("default") ? S.default : S);
    function M(e, t, i) {
        return t && n(e.prototype, t), i && n(e, i), e;
    }
    var t,
        i,
        r,
        O =
            ((t = !1),
                (i = { WebkitTransition: "webkitTransitionEnd", MozTransition: "transitionend", OTransition: "oTransitionEnd otransitionend", transition: "transitionend" }),
                (r = {
                    TRANSITION_END: "bsTransitionEnd",
                    getUID: function (e) {
                        for (; (e += ~~(1e6 * Math.random())), document.getElementById(e); );
                        return e;
                    },
                    getSelectorFromElement: function (e) {
                        var t = e.getAttribute("data-target");
                        (t && "#" !== t) || (t = e.getAttribute("href") || "");
                        try {
                            return 0 < D(document).find(t).length ? t : null;
                        } catch (e) {
                            return null;
                        }
                    },
                    reflow: function (e) {
                        return e.offsetHeight;
                    },
                    triggerTransitionEnd: function (e) {
                        D(e).trigger(t.end);
                    },
                    supportsTransitionEnd: function () {
                        return Boolean(t);
                    },
                    isElement: function (e) {
                        return (e[0] || e).nodeType;
                    },
                    typeCheckConfig: function (e, t, i) {
                        for (var n in i)
                            if (Object.prototype.hasOwnProperty.call(i, n)) {
                                var s = i[n],
                                    a = t[n],
                                    o =
                                        a && r.isElement(a)
                                            ? "element"
                                            : ((o = a),
                                                {}.toString
                                                    .call(o)
                                                    .match(/\s([a-zA-Z]+)/)[1]
                                                    .toLowerCase());
                                if (!new RegExp(s).test(o)) throw new Error(e.toUpperCase() + ': Option "' + n + '" provided type "' + o + '" but expected type "' + s + '".');
                            }
                        var o;
                    },
                }),
                (t = (function () {
                    if (window.QUnit) return !1;
                    var e,
                        t = document.createElement("bootstrap");
                    for (e in i) if (void 0 !== t.style[e]) return { end: i[e] };
                    return !1;
                })()),
                (D.fn.emulateTransitionEnd = function (e) {
                    var t = this,
                        i = !1;
                    return (
                        D(this).one(r.TRANSITION_END, function () {
                            i = !0;
                        }),
                            setTimeout(function () {
                                i || r.triggerTransitionEnd(t);
                            }, e),
                            this
                    );
                }),
            r.supportsTransitionEnd() &&
            (D.event.special[r.TRANSITION_END] = {
                bindType: t.end,
                delegateType: t.end,
                handle: function (e) {
                    if (D(e.target).is(this)) return e.handleObj.handler.apply(this, arguments);
                },
            }),
                r),
        s = (function () {
            var e,
                t = "alert",
                i = D.fn[t],
                n = "close.bs.alert",
                s = "closed.bs.alert",
                a = "click.bs.alert.data-api",
                o = "alert",
                r = "fade",
                l = "show",
                d =
                    (((e = c.prototype).close = function (e) {
                        e = e || this._element;
                        e = this._getRootElement(e);
                        this._triggerCloseEvent(e).isDefaultPrevented() || this._removeElement(e);
                    }),
                        (e.dispose = function () {
                            D.removeData(this._element, "bs.alert"), (this._element = null);
                        }),
                        (e._getRootElement = function (e) {
                            var t = O.getSelectorFromElement(e),
                                i = !1;
                            return t && (i = D(t)[0]), (i = i || D(e).closest("." + o)[0]);
                        }),
                        (e._triggerCloseEvent = function (e) {
                            var t = D.Event(n);
                            return D(e).trigger(t), t;
                        }),
                        (e._removeElement = function (t) {
                            var i = this;
                            D(t).removeClass(l),
                                O.supportsTransitionEnd() && D(t).hasClass(r)
                                    ? D(t)
                                        .one(O.TRANSITION_END, function (e) {
                                            return i._destroyElement(t, e);
                                        })
                                        .emulateTransitionEnd(150)
                                    : this._destroyElement(t);
                        }),
                        (e._destroyElement = function (e) {
                            D(e).detach().trigger(s).remove();
                        }),
                        (c._jQueryInterface = function (i) {
                            return this.each(function () {
                                var e = D(this),
                                    t = e.data("bs.alert");
                                t || ((t = new c(this)), e.data("bs.alert", t)), "close" === i && t[i](this);
                            });
                        }),
                        (c._handleDismiss = function (t) {
                            return function (e) {
                                e && e.preventDefault(), t.close(this);
                            };
                        }),
                        M(c, null, [
                            {
                                key: "VERSION",
                                get: function () {
                                    return "4.0.0-beta.2";
                                },
                            },
                        ]),
                        c);
            function c(e) {
                this._element = e;
            }
            return (
                D(document).on(a, '[data-dismiss="alert"]', d._handleDismiss(new d())),
                    (D.fn[t] = d._jQueryInterface),
                    (D.fn[t].Constructor = d),
                    (D.fn[t].noConflict = function () {
                        return (D.fn[t] = i), d._jQueryInterface;
                    }),
                    d
            );
        })(),
        a = (function () {
            var e,
                t = "button",
                i = D.fn[t],
                a = "active",
                n = "btn",
                s = "focus",
                o = '[data-toggle^="button"]',
                r = '[data-toggle="buttons"]',
                l = "input",
                d = ".active",
                c = ".btn",
                u = "click.bs.button.data-api",
                h = "focus.bs.button.data-api blur.bs.button.data-api",
                p =
                    (((e = f.prototype).toggle = function () {
                        var e = !0,
                            t = !0,
                            i = D(this._element).closest(r)[0];
                        if (i) {
                            var n,
                                s = D(this._element).find(l)[0];
                            if (s) {
                                if (("radio" === s.type && (s.checked && D(this._element).hasClass(a) ? (e = !1) : (n = D(i).find(d)[0]) && D(n).removeClass(a)), e)) {
                                    if (s.hasAttribute("disabled") || i.hasAttribute("disabled") || s.classList.contains("disabled") || i.classList.contains("disabled")) return;
                                    (s.checked = !D(this._element).hasClass(a)), D(s).trigger("change");
                                }
                                s.focus(), (t = !1);
                            }
                        }
                        t && this._element.setAttribute("aria-pressed", !D(this._element).hasClass(a)), e && D(this._element).toggleClass(a);
                    }),
                        (e.dispose = function () {
                            D.removeData(this._element, "bs.button"), (this._element = null);
                        }),
                        (f._jQueryInterface = function (t) {
                            return this.each(function () {
                                var e = D(this).data("bs.button");
                                e || ((e = new f(this)), D(this).data("bs.button", e)), "toggle" === t && e[t]();
                            });
                        }),
                        M(f, null, [
                            {
                                key: "VERSION",
                                get: function () {
                                    return "4.0.0-beta.2";
                                },
                            },
                        ]),
                        f);
            function f(e) {
                this._element = e;
            }
            return (
                D(document)
                    .on(u, o, function (e) {
                        e.preventDefault();
                        e = e.target;
                        D(e).hasClass(n) || (e = D(e).closest(c)), p._jQueryInterface.call(D(e), "toggle");
                    })
                    .on(h, o, function (e) {
                        var t = D(e.target).closest(c)[0];
                        D(t).toggleClass(s, /^focus(in)?$/.test(e.type));
                    }),
                    (D.fn[t] = p._jQueryInterface),
                    (D.fn[t].Constructor = p),
                    (D.fn[t].noConflict = function () {
                        return (D.fn[t] = i), p._jQueryInterface;
                    }),
                    p
            );
        })(),
        o = (function () {
            var e,
                t = "carousel",
                s = "bs.carousel",
                i = "." + s,
                n = D.fn[t],
                a = { interval: 5e3, keyboard: !0, slide: !1, pause: "hover", wrap: !0 },
                o = { interval: "(number|boolean)", keyboard: "boolean", slide: "(boolean|string)", pause: "(string|boolean)", wrap: "boolean" },
                c = "next",
                r = "prev",
                u = "left",
                h = "right",
                p = {
                    SLIDE: "slide" + i,
                    SLID: "slid" + i,
                    KEYDOWN: "keydown" + i,
                    MOUSEENTER: "mouseenter" + i,
                    MOUSELEAVE: "mouseleave" + i,
                    TOUCHEND: "touchend" + i,
                    LOAD_DATA_API: "load.bs.carousel.data-api",
                    CLICK_DATA_API: "click.bs.carousel.data-api",
                },
                l = "carousel",
                f = "active",
                m = "slide",
                v = "carousel-item-right",
                g = "carousel-item-left",
                w = "carousel-item-next",
                y = "carousel-item-prev",
                d = ".active",
                b = ".active.carousel-item",
                _ = ".carousel-item",
                k = ".carousel-item-next, .carousel-item-prev",
                x = ".carousel-indicators",
                C = "[data-slide], [data-slide-to]",
                S = '[data-ride="carousel"]',
                T =
                    (((e = $.prototype).next = function () {
                        this._isSliding || this._slide(c);
                    }),
                        (e.nextWhenVisible = function () {
                            !document.hidden && D(this._element).is(":visible") && "hidden" !== D(this._element).css("visibility") && this.next();
                        }),
                        (e.prev = function () {
                            this._isSliding || this._slide(r);
                        }),
                        (e.pause = function (e) {
                            e || (this._isPaused = !0), D(this._element).find(k)[0] && O.supportsTransitionEnd() && (O.triggerTransitionEnd(this._element), this.cycle(!0)), clearInterval(this._interval), (this._interval = null);
                        }),
                        (e.cycle = function (e) {
                            e || (this._isPaused = !1),
                            this._interval && (clearInterval(this._interval), (this._interval = null)),
                            this._config.interval && !this._isPaused && (this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval));
                        }),
                        (e.to = function (e) {
                            var t = this;
                            this._activeElement = D(this._element).find(b)[0];
                            var i = this._getItemIndex(this._activeElement);
                            if (!(e > this._items.length - 1 || e < 0))
                                if (this._isSliding)
                                    D(this._element).one(p.SLID, function () {
                                        return t.to(e);
                                    });
                                else {
                                    if (i === e) return this.pause(), void this.cycle();
                                    i = i < e ? c : r;
                                    this._slide(i, this._items[e]);
                                }
                        }),
                        (e.dispose = function () {
                            D(this._element).off(i),
                                D.removeData(this._element, s),
                                (this._items = null),
                                (this._config = null),
                                (this._element = null),
                                (this._interval = null),
                                (this._isPaused = null),
                                (this._isSliding = null),
                                (this._activeElement = null),
                                (this._indicatorsElement = null);
                        }),
                        (e._getConfig = function (e) {
                            return (e = D.extend({}, a, e)), O.typeCheckConfig(t, e, o), e;
                        }),
                        (e._addEventListeners = function () {
                            var t = this;
                            this._config.keyboard &&
                            D(this._element).on(p.KEYDOWN, function (e) {
                                return t._keydown(e);
                            }),
                            "hover" === this._config.pause &&
                            (D(this._element)
                                .on(p.MOUSEENTER, function (e) {
                                    return t.pause(e);
                                })
                                .on(p.MOUSELEAVE, function (e) {
                                    return t.cycle(e);
                                }),
                            "ontouchstart" in document.documentElement &&
                            D(this._element).on(p.TOUCHEND, function () {
                                t.pause(),
                                t.touchTimeout && clearTimeout(t.touchTimeout),
                                    (t.touchTimeout = setTimeout(function (e) {
                                        return t.cycle(e);
                                    }, 500 + t._config.interval));
                            }));
                        }),
                        (e._keydown = function (e) {
                            if (!/input|textarea/i.test(e.target.tagName))
                                switch (e.which) {
                                    case 37:
                                        e.preventDefault(), this.prev();
                                        break;
                                    case 39:
                                        e.preventDefault(), this.next();
                                        break;
                                    default:
                                        return;
                                }
                        }),
                        (e._getItemIndex = function (e) {
                            return (this._items = D.makeArray(D(e).parent().find(_))), this._items.indexOf(e);
                        }),
                        (e._getItemByDirection = function (e, t) {
                            var i = e === c,
                                n = e === r,
                                s = this._getItemIndex(t),
                                a = this._items.length - 1;
                            if (((n && 0 === s) || (i && s === a)) && !this._config.wrap) return t;
                            e = (s + (e === r ? -1 : 1)) % this._items.length;
                            return -1 == e ? this._items[this._items.length - 1] : this._items[e];
                        }),
                        (e._triggerSlideEvent = function (e, t) {
                            var i = this._getItemIndex(e),
                                n = this._getItemIndex(D(this._element).find(b)[0]),
                                i = D.Event(p.SLIDE, { relatedTarget: e, direction: t, from: n, to: i });
                            return D(this._element).trigger(i), i;
                        }),
                        (e._setActiveIndicatorElement = function (e) {
                            this._indicatorsElement && (D(this._indicatorsElement).find(d).removeClass(f), (e = this._indicatorsElement.children[this._getItemIndex(e)]) && D(e).addClass(f));
                        }),
                        (e._slide = function (e, t) {
                            var i,
                                n,
                                s,
                                a = this,
                                o = D(this._element).find(b)[0],
                                r = this._getItemIndex(o),
                                l = t || (o && this._getItemByDirection(e, o)),
                                d = this._getItemIndex(l),
                                t = Boolean(this._interval),
                                e = e === c ? ((i = g), (n = w), u) : ((i = v), (n = y), h);
                            l && D(l).hasClass(f)
                                ? (this._isSliding = !1)
                                : !this._triggerSlideEvent(l, e).isDefaultPrevented() &&
                                o &&
                                l &&
                                ((this._isSliding = !0),
                                t && this.pause(),
                                    this._setActiveIndicatorElement(l),
                                    (s = D.Event(p.SLID, { relatedTarget: l, direction: e, from: r, to: d })),
                                    O.supportsTransitionEnd() && D(this._element).hasClass(m)
                                        ? (D(l).addClass(n),
                                            O.reflow(l),
                                            D(o).addClass(i),
                                            D(l).addClass(i),
                                            D(o)
                                                .one(O.TRANSITION_END, function () {
                                                    D(l)
                                                        .removeClass(i + " " + n)
                                                        .addClass(f),
                                                        D(o).removeClass(f + " " + n + " " + i),
                                                        (a._isSliding = !1),
                                                        setTimeout(function () {
                                                            return D(a._element).trigger(s);
                                                        }, 0);
                                                })
                                                .emulateTransitionEnd(600))
                                        : (D(o).removeClass(f), D(l).addClass(f), (this._isSliding = !1), D(this._element).trigger(s)),
                                t && this.cycle());
                        }),
                        ($._jQueryInterface = function (n) {
                            return this.each(function () {
                                var e = D(this).data(s),
                                    t = D.extend({}, a, D(this).data());
                                "object" == typeof n && D.extend(t, n);
                                var i = "string" == typeof n ? n : t.slide;
                                if ((e || ((e = new $(this, t)), D(this).data(s, e)), "number" == typeof n)) e.to(n);
                                else if ("string" == typeof i) {
                                    if (void 0 === e[i]) throw new Error('No method named "' + i + '"');
                                    e[i]();
                                } else t.interval && (e.pause(), e.cycle());
                            });
                        }),
                        ($._dataApiClickHandler = function (e) {
                            var t,
                                i,
                                n = O.getSelectorFromElement(this);
                            !n ||
                            ((t = D(n)[0]) &&
                                D(t).hasClass(l) &&
                                ((i = D.extend({}, D(t).data(), D(this).data())), (n = this.getAttribute("data-slide-to")) && (i.interval = !1), $._jQueryInterface.call(D(t), i), n && D(t).data(s).to(n), e.preventDefault()));
                        }),
                        M($, null, [
                            {
                                key: "VERSION",
                                get: function () {
                                    return "4.0.0-beta.2";
                                },
                            },
                            {
                                key: "Default",
                                get: function () {
                                    return a;
                                },
                            },
                        ]),
                        $);
            function $(e, t) {
                (this._items = null),
                    (this._interval = null),
                    (this._activeElement = null),
                    (this._isPaused = !1),
                    (this._isSliding = !1),
                    (this.touchTimeout = null),
                    (this._config = this._getConfig(t)),
                    (this._element = D(e)[0]),
                    (this._indicatorsElement = D(this._element).find(x)[0]),
                    this._addEventListeners();
            }
            return (
                D(document).on(p.CLICK_DATA_API, C, T._dataApiClickHandler),
                    D(window).on(p.LOAD_DATA_API, function () {
                        D(S).each(function () {
                            var e = D(this);
                            T._jQueryInterface.call(e, e.data());
                        });
                    }),
                    (D.fn[t] = T._jQueryInterface),
                    (D.fn[t].Constructor = T),
                    (D.fn[t].noConflict = function () {
                        return (D.fn[t] = n), T._jQueryInterface;
                    }),
                    T
            );
        })(),
        l = (function () {
            var e,
                t = "collapse",
                a = "bs.collapse",
                i = D.fn[t],
                s = { toggle: !0, parent: "" },
                n = { toggle: "boolean", parent: "(string|element)" },
                o = "show.bs.collapse",
                r = "shown.bs.collapse",
                l = "hide.bs.collapse",
                d = "hidden.bs.collapse",
                c = "click.bs.collapse.data-api",
                u = "show",
                h = "collapse",
                p = "collapsing",
                f = "collapsed",
                m = "width",
                v = "height",
                g = ".show, .collapsing",
                w = '[data-toggle="collapse"]',
                y =
                    (((e = b.prototype).toggle = function () {
                        D(this._element).hasClass(u) ? this.hide() : this.show();
                    }),
                        (e.show = function () {
                            var e,
                                t,
                                i,
                                n,
                                s = this;
                            this._isTransitioning ||
                            D(this._element).hasClass(u) ||
                            (this._parent && ((n = D.makeArray(D(this._parent).children().children(g))).length || (n = null)),
                            (n && (i = D(n).data(a)) && i._isTransitioning) ||
                            ((e = D.Event(o)),
                                D(this._element).trigger(e),
                            e.isDefaultPrevented() ||
                            (n && (b._jQueryInterface.call(D(n), "hide"), i || D(n).data(a, null)),
                                (t = this._getDimension()),
                                D(this._element).removeClass(h).addClass(p),
                                (this._element.style[t] = 0),
                            this._triggerArray.length && D(this._triggerArray).removeClass(f).attr("aria-expanded", !0),
                                this.setTransitioning(!0),
                                (i = function () {
                                    D(s._element).removeClass(p).addClass(h).addClass(u), (s._element.style[t] = ""), s.setTransitioning(!1), D(s._element).trigger(r);
                                }),
                                O.supportsTransitionEnd()
                                    ? ((n = "scroll" + (t[0].toUpperCase() + t.slice(1))), D(this._element).one(O.TRANSITION_END, i).emulateTransitionEnd(600), (this._element.style[t] = this._element[n] + "px"))
                                    : i())));
                        }),
                        (e.hide = function () {
                            var e = this;
                            if (!this._isTransitioning && D(this._element).hasClass(u)) {
                                var t = D.Event(l);
                                if ((D(this._element).trigger(t), !t.isDefaultPrevented())) {
                                    var i = this._getDimension();
                                    if (((this._element.style[i] = this._element.getBoundingClientRect()[i] + "px"), O.reflow(this._element), D(this._element).addClass(p).removeClass(h).removeClass(u), this._triggerArray.length))
                                        for (var n = 0; n < this._triggerArray.length; n++) {
                                            var s = this._triggerArray[n],
                                                a = O.getSelectorFromElement(s);
                                            null !== a && (D(a).hasClass(u) || D(s).addClass(f).attr("aria-expanded", !1));
                                        }
                                    this.setTransitioning(!0);
                                    t = function () {
                                        e.setTransitioning(!1), D(e._element).removeClass(p).addClass(h).trigger(d);
                                    };
                                    (this._element.style[i] = ""), O.supportsTransitionEnd() ? D(this._element).one(O.TRANSITION_END, t).emulateTransitionEnd(600) : t();
                                }
                            }
                        }),
                        (e.setTransitioning = function (e) {
                            this._isTransitioning = e;
                        }),
                        (e.dispose = function () {
                            D.removeData(this._element, a), (this._config = null), (this._parent = null), (this._element = null), (this._triggerArray = null), (this._isTransitioning = null);
                        }),
                        (e._getConfig = function (e) {
                            return ((e = D.extend({}, s, e)).toggle = Boolean(e.toggle)), O.typeCheckConfig(t, e, n), e;
                        }),
                        (e._getDimension = function () {
                            return D(this._element).hasClass(m) ? m : v;
                        }),
                        (e._getParent = function () {
                            var i = this,
                                e = null;
                            O.isElement(this._config.parent) ? ((e = this._config.parent), void 0 !== this._config.parent.jquery && (e = this._config.parent[0])) : (e = D(this._config.parent)[0]);
                            var t = '[data-toggle="collapse"][data-parent="' + this._config.parent + '"]';
                            return (
                                D(e)
                                    .find(t)
                                    .each(function (e, t) {
                                        i._addAriaAndCollapsedClass(b._getTargetFromElement(t), [t]);
                                    }),
                                    e
                            );
                        }),
                        (e._addAriaAndCollapsedClass = function (e, t) {
                            e && ((e = D(e).hasClass(u)), t.length && D(t).toggleClass(f, !e).attr("aria-expanded", e));
                        }),
                        (b._getTargetFromElement = function (e) {
                            e = O.getSelectorFromElement(e);
                            return e ? D(e)[0] : null;
                        }),
                        (b._jQueryInterface = function (n) {
                            return this.each(function () {
                                var e = D(this),
                                    t = e.data(a),
                                    i = D.extend({}, s, e.data(), "object" == typeof n && n);
                                if ((!t && i.toggle && /show|hide/.test(n) && (i.toggle = !1), t || ((t = new b(this, i)), e.data(a, t)), "string" == typeof n)) {
                                    if (void 0 === t[n]) throw new Error('No method named "' + n + '"');
                                    t[n]();
                                }
                            });
                        }),
                        M(b, null, [
                            {
                                key: "VERSION",
                                get: function () {
                                    return "4.0.0-beta.2";
                                },
                            },
                            {
                                key: "Default",
                                get: function () {
                                    return s;
                                },
                            },
                        ]),
                        b);
            function b(e, t) {
                (this._isTransitioning = !1),
                    (this._element = e),
                    (this._config = this._getConfig(t)),
                    (this._triggerArray = D.makeArray(D('[data-toggle="collapse"][href="#' + e.id + '"],[data-toggle="collapse"][data-target="#' + e.id + '"]')));
                for (var i = D(w), n = 0; n < i.length; n++) {
                    var s = i[n],
                        a = O.getSelectorFromElement(s);
                    null !== a && 0 < D(a).filter(e).length && this._triggerArray.push(s);
                }
                (this._parent = this._config.parent ? this._getParent() : null), this._config.parent || this._addAriaAndCollapsedClass(this._element, this._triggerArray), this._config.toggle && this.toggle();
            }
            return (
                D(document).on(c, w, function (e) {
                    "A" === e.currentTarget.tagName && e.preventDefault();
                    var i = D(this),
                        e = O.getSelectorFromElement(this);
                    D(e).each(function () {
                        var e = D(this),
                            t = e.data(a) ? "toggle" : i.data();
                        y._jQueryInterface.call(e, t);
                    });
                }),
                    (D.fn[t] = y._jQueryInterface),
                    (D.fn[t].Constructor = y),
                    (D.fn[t].noConflict = function () {
                        return (D.fn[t] = i), y._jQueryInterface;
                    }),
                    y
            );
        })(),
        d = (function () {
            if (void 0 === S) throw new Error("Bootstrap dropdown require Popper.js (https://popper.js.org)");
            var e,
                t = "dropdown",
                r = "bs.dropdown",
                i = "." + r,
                n = D.fn[t],
                s = new RegExp("38|40|27"),
                l = {
                    HIDE: "hide" + i,
                    HIDDEN: "hidden" + i,
                    SHOW: "show" + i,
                    SHOWN: "shown" + i,
                    CLICK: "click" + i,
                    CLICK_DATA_API: "click.bs.dropdown.data-api",
                    KEYDOWN_DATA_API: "keydown.bs.dropdown.data-api",
                    KEYUP_DATA_API: "keyup.bs.dropdown.data-api",
                },
                a = "disabled",
                d = "show",
                o = "dropup",
                c = "dropdown-menu-right",
                u = "dropdown-menu-left",
                h = '[data-toggle="dropdown"]',
                p = ".dropdown form",
                f = ".dropdown-menu",
                m = ".navbar-nav",
                v = ".dropdown-menu .dropdown-item:not(.disabled)",
                g = "top-start",
                w = "top-end",
                y = "bottom-start",
                b = "bottom-end",
                _ = { offset: 0, flip: !0 },
                k = { offset: "(number|string|function)", flip: "boolean" },
                x =
                    (((e = C.prototype).toggle = function () {
                        var e, t, i;
                        this._element.disabled ||
                        D(this._element).hasClass(a) ||
                        ((e = C._getParentFromElement(this._element)),
                            (i = D(this._menu).hasClass(d)),
                            C._clearMenus(),
                        i ||
                        ((t = { relatedTarget: this._element }),
                            (i = D.Event(l.SHOW, t)),
                            D(e).trigger(i),
                        i.isDefaultPrevented() ||
                        ((i = this._element),
                        D(e).hasClass(o) && (D(this._menu).hasClass(u) || D(this._menu).hasClass(c)) && (i = e),
                            (this._popper = new S(i, this._menu, this._getPopperConfig())),
                        "ontouchstart" in document.documentElement && !D(e).closest(m).length && D("body").children().on("mouseover", null, D.noop),
                            this._element.focus(),
                            this._element.setAttribute("aria-expanded", !0),
                            D(this._menu).toggleClass(d),
                            D(e).toggleClass(d).trigger(D.Event(l.SHOWN, t)))));
                    }),
                        (e.dispose = function () {
                            D.removeData(this._element, r), D(this._element).off(i), (this._element = null), (this._menu = null) !== this._popper && this._popper.destroy(), (this._popper = null);
                        }),
                        (e.update = function () {
                            (this._inNavbar = this._detectNavbar()), null !== this._popper && this._popper.scheduleUpdate();
                        }),
                        (e._addEventListeners = function () {
                            var t = this;
                            D(this._element).on(l.CLICK, function (e) {
                                e.preventDefault(), e.stopPropagation(), t.toggle();
                            });
                        }),
                        (e._getConfig = function (e) {
                            return (e = D.extend({}, this.constructor.Default, D(this._element).data(), e)), O.typeCheckConfig(t, e, this.constructor.DefaultType), e;
                        }),
                        (e._getMenuElement = function () {
                            var e;
                            return this._menu || ((e = C._getParentFromElement(this._element)), (this._menu = D(e).find(f)[0])), this._menu;
                        }),
                        (e._getPlacement = function () {
                            var e = D(this._element).parent(),
                                t = y;
                            return e.hasClass(o) ? ((t = g), D(this._menu).hasClass(c) && (t = w)) : D(this._menu).hasClass(c) && (t = b), t;
                        }),
                        (e._detectNavbar = function () {
                            return 0 < D(this._element).closest(".navbar").length;
                        }),
                        (e._getPopperConfig = function () {
                            var t = this,
                                e = {};
                            "function" == typeof this._config.offset
                                ? (e.fn = function (e) {
                                    return (e.offsets = D.extend({}, e.offsets, t._config.offset(e.offsets) || {})), e;
                                })
                                : (e.offset = this._config.offset);
                            e = { placement: this._getPlacement(), modifiers: { offset: e, flip: { enabled: this._config.flip } } };
                            return this._inNavbar && (e.modifiers.applyStyle = { enabled: !this._inNavbar }), e;
                        }),
                        (C._jQueryInterface = function (t) {
                            return this.each(function () {
                                var e = D(this).data(r);
                                if ((e || ((e = new C(this, "object" == typeof t ? t : null)), D(this).data(r, e)), "string" == typeof t)) {
                                    if (void 0 === e[t]) throw new Error('No method named "' + t + '"');
                                    e[t]();
                                }
                            });
                        }),
                        (C._clearMenus = function (e) {
                            if (!e || (3 !== e.which && ("keyup" !== e.type || 9 === e.which)))
                                for (var t = D.makeArray(D(h)), i = 0; i < t.length; i++) {
                                    var n,
                                        s = C._getParentFromElement(t[i]),
                                        a = D(t[i]).data(r),
                                        o = { relatedTarget: t[i] };
                                    a &&
                                    ((n = a._menu),
                                    !D(s).hasClass(d) ||
                                    (e && (("click" === e.type && /input|textarea/i.test(e.target.tagName)) || ("keyup" === e.type && 9 === e.which)) && D.contains(s, e.target)) ||
                                    ((a = D.Event(l.HIDE, o)),
                                        D(s).trigger(a),
                                    a.isDefaultPrevented() ||
                                    ("ontouchstart" in document.documentElement && D("body").children().off("mouseover", null, D.noop),
                                        t[i].setAttribute("aria-expanded", "false"),
                                        D(n).removeClass(d),
                                        D(s).removeClass(d).trigger(D.Event(l.HIDDEN, o)))));
                                }
                        }),
                        (C._getParentFromElement = function (e) {
                            var t,
                                i = O.getSelectorFromElement(e);
                            return i && (t = D(i)[0]), t || e.parentNode;
                        }),
                        (C._dataApiKeydownHandler = function (e) {
                            var t, i, n;
                            !s.test(e.which) ||
                            (/button/i.test(e.target.tagName) && 32 === e.which) ||
                            /input|textarea/i.test(e.target.tagName) ||
                            (e.preventDefault(), e.stopPropagation(), this.disabled || D(this).hasClass(a)) ||
                            ((n = C._getParentFromElement(this)),
                                ((i = D(n).hasClass(d)) || (27 === e.which && 32 === e.which)) && (!i || (27 !== e.which && 32 !== e.which))
                                    ? (t = D(n).find(v).get()).length && ((i = t.indexOf(e.target)), 38 === e.which && 0 < i && i--, 40 === e.which && i < t.length - 1 && i++, i < 0 && (i = 0), t[i].focus())
                                    : (27 === e.which && ((n = D(n).find(h)[0]), D(n).trigger("focus")), D(this).trigger("click")));
                        }),
                        M(C, null, [
                            {
                                key: "VERSION",
                                get: function () {
                                    return "4.0.0-beta.2";
                                },
                            },
                            {
                                key: "Default",
                                get: function () {
                                    return _;
                                },
                            },
                            {
                                key: "DefaultType",
                                get: function () {
                                    return k;
                                },
                            },
                        ]),
                        C);
            function C(e, t) {
                (this._element = e), (this._popper = null), (this._config = this._getConfig(t)), (this._menu = this._getMenuElement()), (this._inNavbar = this._detectNavbar()), this._addEventListeners();
            }
            return (
                D(document)
                    .on(l.KEYDOWN_DATA_API, h, x._dataApiKeydownHandler)
                    .on(l.KEYDOWN_DATA_API, f, x._dataApiKeydownHandler)
                    .on(l.CLICK_DATA_API + " " + l.KEYUP_DATA_API, x._clearMenus)
                    .on(l.CLICK_DATA_API, h, function (e) {
                        e.preventDefault(), e.stopPropagation(), x._jQueryInterface.call(D(this), "toggle");
                    })
                    .on(l.CLICK_DATA_API, p, function (e) {
                        e.stopPropagation();
                    }),
                    (D.fn[t] = x._jQueryInterface),
                    (D.fn[t].Constructor = x),
                    (D.fn[t].noConflict = function () {
                        return (D.fn[t] = n), x._jQueryInterface;
                    }),
                    x
            );
        })(),
        c = (function () {
            var e,
                t = "modal",
                i = D.fn[t],
                n = { backdrop: !0, keyboard: !0, focus: !0, show: !0 },
                s = { backdrop: "(boolean|string)", keyboard: "boolean", focus: "boolean", show: "boolean" },
                a = "hide.bs.modal",
                o = "hidden.bs.modal",
                r = "show.bs.modal",
                l = "shown.bs.modal",
                d = "focusin.bs.modal",
                c = "resize.bs.modal",
                u = "click.dismiss.bs.modal",
                h = "keydown.dismiss.bs.modal",
                p = "mouseup.dismiss.bs.modal",
                f = "mousedown.dismiss.bs.modal",
                m = "click.bs.modal.data-api",
                v = "modal-scrollbar-measure",
                g = "modal-backdrop",
                w = "modal-open",
                y = "fade",
                b = "show",
                _ = ".modal-dialog",
                k = '[data-toggle="modal"]',
                x = '[data-dismiss="modal"]',
                C = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",
                S = ".sticky-top",
                T = ".navbar-toggler",
                $ =
                    (((e = E.prototype).toggle = function (e) {
                        return this._isShown ? this.hide() : this.show(e);
                    }),
                        (e.show = function (e) {
                            var t,
                                i = this;
                            this._isTransitioning ||
                            this._isShown ||
                            (O.supportsTransitionEnd() && D(this._element).hasClass(y) && (this._isTransitioning = !0),
                                (t = D.Event(r, { relatedTarget: e })),
                                D(this._element).trigger(t),
                            this._isShown ||
                            t.isDefaultPrevented() ||
                            ((this._isShown = !0),
                                this._checkScrollbar(),
                                this._setScrollbar(),
                                this._adjustDialog(),
                                D(document.body).addClass(w),
                                this._setEscapeEvent(),
                                this._setResizeEvent(),
                                D(this._element).on(u, x, function (e) {
                                    return i.hide(e);
                                }),
                                D(this._dialog).on(f, function () {
                                    D(i._element).one(p, function (e) {
                                        D(e.target).is(i._element) && (i._ignoreBackdropClick = !0);
                                    });
                                }),
                                this._showBackdrop(function () {
                                    return i._showElement(e);
                                })));
                        }),
                        (e.hide = function (e) {
                            var t = this;
                            e && e.preventDefault(),
                            !this._isTransitioning &&
                            this._isShown &&
                            ((e = D.Event(a)),
                                D(this._element).trigger(e),
                            this._isShown &&
                            !e.isDefaultPrevented() &&
                            ((this._isShown = !1),
                            (e = O.supportsTransitionEnd() && D(this._element).hasClass(y)) && (this._isTransitioning = !0),
                                this._setEscapeEvent(),
                                this._setResizeEvent(),
                                D(document).off(d),
                                D(this._element).removeClass(b),
                                D(this._element).off(u),
                                D(this._dialog).off(f),
                                e
                                    ? D(this._element)
                                        .one(O.TRANSITION_END, function (e) {
                                            return t._hideModal(e);
                                        })
                                        .emulateTransitionEnd(300)
                                    : this._hideModal()));
                        }),
                        (e.dispose = function () {
                            D.removeData(this._element, "bs.modal"),
                                D(window, document, this._element, this._backdrop).off(".bs.modal"),
                                (this._config = null),
                                (this._element = null),
                                (this._dialog = null),
                                (this._backdrop = null),
                                (this._isShown = null),
                                (this._isBodyOverflowing = null),
                                (this._ignoreBackdropClick = null),
                                (this._scrollbarWidth = null);
                        }),
                        (e.handleUpdate = function () {
                            this._adjustDialog();
                        }),
                        (e._getConfig = function (e) {
                            return (e = D.extend({}, n, e)), O.typeCheckConfig(t, e, s), e;
                        }),
                        (e._showElement = function (e) {
                            var t = this,
                                i = O.supportsTransitionEnd() && D(this._element).hasClass(y);
                            (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE) || document.body.appendChild(this._element),
                                (this._element.style.display = "block"),
                                this._element.removeAttribute("aria-hidden"),
                                (this._element.scrollTop = 0),
                            i && O.reflow(this._element),
                                D(this._element).addClass(b),
                            this._config.focus && this._enforceFocus();
                            var n = D.Event(l, { relatedTarget: e }),
                                e = function () {
                                    t._config.focus && t._element.focus(), (t._isTransitioning = !1), D(t._element).trigger(n);
                                };
                            i ? D(this._dialog).one(O.TRANSITION_END, e).emulateTransitionEnd(300) : e();
                        }),
                        (e._enforceFocus = function () {
                            var t = this;
                            D(document)
                                .off(d)
                                .on(d, function (e) {
                                    document === e.target || t._element === e.target || D(t._element).has(e.target).length || t._element.focus();
                                });
                        }),
                        (e._setEscapeEvent = function () {
                            var t = this;
                            this._isShown && this._config.keyboard
                                ? D(this._element).on(h, function (e) {
                                    27 === e.which && (e.preventDefault(), t.hide());
                                })
                                : this._isShown || D(this._element).off(h);
                        }),
                        (e._setResizeEvent = function () {
                            var t = this;
                            this._isShown
                                ? D(window).on(c, function (e) {
                                    return t.handleUpdate(e);
                                })
                                : D(window).off(c);
                        }),
                        (e._hideModal = function () {
                            var e = this;
                            (this._element.style.display = "none"),
                                this._element.setAttribute("aria-hidden", !0),
                                (this._isTransitioning = !1),
                                this._showBackdrop(function () {
                                    D(document.body).removeClass(w), e._resetAdjustments(), e._resetScrollbar(), D(e._element).trigger(o);
                                });
                        }),
                        (e._removeBackdrop = function () {
                            this._backdrop && (D(this._backdrop).remove(), (this._backdrop = null));
                        }),
                        (e._showBackdrop = function (e) {
                            var t,
                                i = this,
                                n = D(this._element).hasClass(y) ? y : "";
                            this._isShown && this._config.backdrop
                                ? ((t = O.supportsTransitionEnd() && n),
                                    (this._backdrop = document.createElement("div")),
                                    (this._backdrop.className = g),
                                n && D(this._backdrop).addClass(n),
                                    D(this._backdrop).appendTo(document.body),
                                    D(this._element).on(u, function (e) {
                                        i._ignoreBackdropClick ? (i._ignoreBackdropClick = !1) : e.target === e.currentTarget && ("static" === i._config.backdrop ? i._element.focus() : i.hide());
                                    }),
                                t && O.reflow(this._backdrop),
                                    D(this._backdrop).addClass(b),
                                e && (t ? D(this._backdrop).one(O.TRANSITION_END, e).emulateTransitionEnd(150) : e()))
                                : !this._isShown && this._backdrop
                                    ? (D(this._backdrop).removeClass(b),
                                        (t = function () {
                                            i._removeBackdrop(), e && e();
                                        }),
                                        O.supportsTransitionEnd() && D(this._element).hasClass(y) ? D(this._backdrop).one(O.TRANSITION_END, t).emulateTransitionEnd(150) : t())
                                    : e && e();
                        }),
                        (e._adjustDialog = function () {
                            var e = this._element.scrollHeight > document.documentElement.clientHeight;
                            !this._isBodyOverflowing && e && (this._element.style.paddingLeft = this._scrollbarWidth + "px"), this._isBodyOverflowing && !e && (this._element.style.paddingRight = this._scrollbarWidth + "px");
                        }),
                        (e._resetAdjustments = function () {
                            (this._element.style.paddingLeft = ""), (this._element.style.paddingRight = "");
                        }),
                        (e._checkScrollbar = function () {
                            var e = document.body.getBoundingClientRect();
                            (this._isBodyOverflowing = e.left + e.right < window.innerWidth), (this._scrollbarWidth = this._getScrollbarWidth());
                        }),
                        (e._setScrollbar = function () {
                            var e,
                                t,
                                s = this;
                            this._isBodyOverflowing &&
                            (D(C).each(function (e, t) {
                                var i = D(t)[0].style.paddingRight,
                                    n = D(t).css("padding-right");
                                D(t)
                                    .data("padding-right", i)
                                    .css("padding-right", parseFloat(n) + s._scrollbarWidth + "px");
                            }),
                                D(S).each(function (e, t) {
                                    var i = D(t)[0].style.marginRight,
                                        n = D(t).css("margin-right");
                                    D(t)
                                        .data("margin-right", i)
                                        .css("margin-right", parseFloat(n) - s._scrollbarWidth + "px");
                                }),
                                D(T).each(function (e, t) {
                                    var i = D(t)[0].style.marginRight,
                                        n = D(t).css("margin-right");
                                    D(t)
                                        .data("margin-right", i)
                                        .css("margin-right", parseFloat(n) + s._scrollbarWidth + "px");
                                }),
                                (e = document.body.style.paddingRight),
                                (t = D("body").css("padding-right")),
                                D("body")
                                    .data("padding-right", e)
                                    .css("padding-right", parseFloat(t) + this._scrollbarWidth + "px"));
                        }),
                        (e._resetScrollbar = function () {
                            D(C).each(function (e, t) {
                                var i = D(t).data("padding-right");
                                void 0 !== i && D(t).css("padding-right", i).removeData("padding-right");
                            }),
                                D(S + ", " + T).each(function (e, t) {
                                    var i = D(t).data("margin-right");
                                    void 0 !== i && D(t).css("margin-right", i).removeData("margin-right");
                                });
                            var e = D("body").data("padding-right");
                            void 0 !== e && D("body").css("padding-right", e).removeData("padding-right");
                        }),
                        (e._getScrollbarWidth = function () {
                            var e = document.createElement("div");
                            (e.className = v), document.body.appendChild(e);
                            var t = e.getBoundingClientRect().width - e.clientWidth;
                            return document.body.removeChild(e), t;
                        }),
                        (E._jQueryInterface = function (i, n) {
                            return this.each(function () {
                                var e = D(this).data("bs.modal"),
                                    t = D.extend({}, E.Default, D(this).data(), "object" == typeof i && i);
                                if ((e || ((e = new E(this, t)), D(this).data("bs.modal", e)), "string" == typeof i)) {
                                    if (void 0 === e[i]) throw new Error('No method named "' + i + '"');
                                    e[i](n);
                                } else t.show && e.show(n);
                            });
                        }),
                        M(E, null, [
                            {
                                key: "VERSION",
                                get: function () {
                                    return "4.0.0-beta.2";
                                },
                            },
                            {
                                key: "Default",
                                get: function () {
                                    return n;
                                },
                            },
                        ]),
                        E);
            function E(e, t) {
                (this._config = this._getConfig(t)),
                    (this._element = e),
                    (this._dialog = D(e).find(_)[0]),
                    (this._backdrop = null),
                    (this._isShown = !1),
                    (this._isBodyOverflowing = !1),
                    (this._ignoreBackdropClick = !1),
                    (this._originalBodyPadding = 0),
                    (this._scrollbarWidth = 0);
            }
            return (
                D(document).on(m, k, function (e) {
                    var t,
                        i = this,
                        n = O.getSelectorFromElement(this);
                    n && (t = D(n)[0]);
                    n = D(t).data("bs.modal") ? "toggle" : D.extend({}, D(t).data(), D(this).data());
                    ("A" !== this.tagName && "AREA" !== this.tagName) || e.preventDefault();
                    var s = D(t).one(r, function (e) {
                        e.isDefaultPrevented() ||
                        s.one(o, function () {
                            D(i).is(":visible") && i.focus();
                        });
                    });
                    $._jQueryInterface.call(D(t), n, this);
                }),
                    (D.fn[t] = $._jQueryInterface),
                    (D.fn[t].Constructor = $),
                    (D.fn[t].noConflict = function () {
                        return (D.fn[t] = i), $._jQueryInterface;
                    }),
                    $
            );
        })(),
        f = (function () {
            if (void 0 === S) throw new Error("Bootstrap tooltips require Popper.js (https://popper.js.org)");
            var e,
                t = "tooltip",
                i = ".bs.tooltip",
                n = D.fn[t],
                s = new RegExp("(^|\\s)bs-tooltip\\S+", "g"),
                a = {
                    animation: "boolean",
                    template: "string",
                    title: "(string|element|function)",
                    trigger: "string",
                    delay: "(number|object)",
                    html: "boolean",
                    selector: "(string|boolean)",
                    placement: "(string|function)",
                    offset: "(number|string)",
                    container: "(string|element|boolean)",
                    fallbackPlacement: "(string|array)",
                },
                o = { AUTO: "auto", TOP: "top", RIGHT: "right", BOTTOM: "bottom", LEFT: "left" },
                r = {
                    animation: !0,
                    template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
                    trigger: "hover focus",
                    title: "",
                    delay: 0,
                    html: !1,
                    selector: !1,
                    placement: "top",
                    offset: 0,
                    container: !1,
                    fallbackPlacement: "flip",
                },
                l = "show",
                d = "out",
                c = {
                    HIDE: "hide" + i,
                    HIDDEN: "hidden" + i,
                    SHOW: "show" + i,
                    SHOWN: "shown" + i,
                    INSERTED: "inserted" + i,
                    CLICK: "click" + i,
                    FOCUSIN: "focusin" + i,
                    FOCUSOUT: "focusout" + i,
                    MOUSEENTER: "mouseenter" + i,
                    MOUSELEAVE: "mouseleave" + i,
                },
                u = "fade",
                h = "show",
                p = ".tooltip-inner",
                f = ".arrow",
                m = "hover",
                v = "focus",
                g = "click",
                w = "manual",
                y =
                    (((e = b.prototype).enable = function () {
                        this._isEnabled = !0;
                    }),
                        (e.disable = function () {
                            this._isEnabled = !1;
                        }),
                        (e.toggleEnabled = function () {
                            this._isEnabled = !this._isEnabled;
                        }),
                        (e.toggle = function (e) {
                            var t, i;
                            this._isEnabled &&
                            (e
                                ? ((t = this.constructor.DATA_KEY),
                                (i = D(e.currentTarget).data(t)) || ((i = new this.constructor(e.currentTarget, this._getDelegateConfig())), D(e.currentTarget).data(t, i)),
                                    (i._activeTrigger.click = !i._activeTrigger.click),
                                    i._isWithActiveTrigger() ? i._enter(null, i) : i._leave(null, i))
                                : D(this.getTipElement()).hasClass(h)
                                    ? this._leave(null, this)
                                    : this._enter(null, this));
                        }),
                        (e.dispose = function () {
                            clearTimeout(this._timeout),
                                D.removeData(this.element, this.constructor.DATA_KEY),
                                D(this.element).off(this.constructor.EVENT_KEY),
                                D(this.element).closest(".modal").off("hide.bs.modal"),
                            this.tip && D(this.tip).remove(),
                                (this._isEnabled = null),
                                (this._timeout = null),
                                (this._hoverState = null),
                            (this._activeTrigger = null) !== this._popper && this._popper.destroy(),
                                (this._popper = null),
                                (this.element = null),
                                (this.config = null),
                                (this.tip = null);
                        }),
                        (e.show = function () {
                            var t = this;
                            if ("none" === D(this.element).css("display")) throw new Error("Please use show on visible elements");
                            var e,
                                i,
                                n = D.Event(this.constructor.Event.SHOW);
                            this.isWithContent() &&
                            this._isEnabled &&
                            (D(this.element).trigger(n),
                                (e = D.contains(this.element.ownerDocument.documentElement, this.element)),
                            !n.isDefaultPrevented() &&
                            e &&
                            ((i = this.getTipElement()),
                                (n = O.getUID(this.constructor.NAME)),
                                i.setAttribute("id", n),
                                this.element.setAttribute("aria-describedby", n),
                                this.setContent(),
                            this.config.animation && D(i).addClass(u),
                                (e = "function" == typeof this.config.placement ? this.config.placement.call(this, i, this.element) : this.config.placement),
                                (n = this._getAttachment(e)),
                                this.addAttachmentClass(n),
                                (e = !1 === this.config.container ? document.body : D(this.config.container)),
                                D(i).data(this.constructor.DATA_KEY, this),
                            D.contains(this.element.ownerDocument.documentElement, this.tip) || D(i).appendTo(e),
                                D(this.element).trigger(this.constructor.Event.INSERTED),
                                (this._popper = new S(this.element, i, {
                                    placement: n,
                                    modifiers: { offset: { offset: this.config.offset }, flip: { behavior: this.config.fallbackPlacement }, arrow: { element: f } },
                                    onCreate: function (e) {
                                        e.originalPlacement !== e.placement && t._handlePopperPlacementChange(e);
                                    },
                                    onUpdate: function (e) {
                                        t._handlePopperPlacementChange(e);
                                    },
                                })),
                                D(i).addClass(h),
                            "ontouchstart" in document.documentElement && D("body").children().on("mouseover", null, D.noop),
                                (i = function () {
                                    t.config.animation && t._fixTransition();
                                    var e = t._hoverState;
                                    (t._hoverState = null), D(t.element).trigger(t.constructor.Event.SHOWN), e === d && t._leave(null, t);
                                }),
                                O.supportsTransitionEnd() && D(this.tip).hasClass(u) ? D(this.tip).one(O.TRANSITION_END, i).emulateTransitionEnd(b._TRANSITION_DURATION) : i()));
                        }),
                        (e.hide = function (e) {
                            function t() {
                                i._hoverState !== l && n.parentNode && n.parentNode.removeChild(n),
                                    i._cleanTipClass(),
                                    i.element.removeAttribute("aria-describedby"),
                                    D(i.element).trigger(i.constructor.Event.HIDDEN),
                                null !== i._popper && i._popper.destroy(),
                                e && e();
                            }
                            var i = this,
                                n = this.getTipElement(),
                                s = D.Event(this.constructor.Event.HIDE);
                            D(this.element).trigger(s),
                            s.isDefaultPrevented() ||
                            (D(n).removeClass(h),
                            "ontouchstart" in document.documentElement && D("body").children().off("mouseover", null, D.noop),
                                (this._activeTrigger[g] = !1),
                                (this._activeTrigger[v] = !1),
                                (this._activeTrigger[m] = !1),
                                O.supportsTransitionEnd() && D(this.tip).hasClass(u) ? D(n).one(O.TRANSITION_END, t).emulateTransitionEnd(150) : t(),
                                (this._hoverState = ""));
                        }),
                        (e.update = function () {
                            null !== this._popper && this._popper.scheduleUpdate();
                        }),
                        (e.isWithContent = function () {
                            return Boolean(this.getTitle());
                        }),
                        (e.addAttachmentClass = function (e) {
                            D(this.getTipElement()).addClass("bs-tooltip-" + e);
                        }),
                        (e.getTipElement = function () {
                            return (this.tip = this.tip || D(this.config.template)[0]), this.tip;
                        }),
                        (e.setContent = function () {
                            var e = D(this.getTipElement());
                            this.setElementContent(e.find(p), this.getTitle()), e.removeClass(u + " " + h);
                        }),
                        (e.setElementContent = function (e, t) {
                            var i = this.config.html;
                            "object" == typeof t && (t.nodeType || t.jquery) ? (i ? D(t).parent().is(e) || e.empty().append(t) : e.text(D(t).text())) : e[i ? "html" : "text"](t);
                        }),
                        (e.getTitle = function () {
                            return this.element.getAttribute("data-original-title") || ("function" == typeof this.config.title ? this.config.title.call(this.element) : this.config.title);
                        }),
                        (e._getAttachment = function (e) {
                            return o[e.toUpperCase()];
                        }),
                        (e._setListeners = function () {
                            var i = this;
                            this.config.trigger.split(" ").forEach(function (e) {
                                var t;
                                "click" === e
                                    ? D(i.element).on(i.constructor.Event.CLICK, i.config.selector, function (e) {
                                        return i.toggle(e);
                                    })
                                    : e !== w &&
                                    ((t = e === m ? i.constructor.Event.MOUSEENTER : i.constructor.Event.FOCUSIN),
                                        (e = e === m ? i.constructor.Event.MOUSELEAVE : i.constructor.Event.FOCUSOUT),
                                        D(i.element)
                                            .on(t, i.config.selector, function (e) {
                                                return i._enter(e);
                                            })
                                            .on(e, i.config.selector, function (e) {
                                                return i._leave(e);
                                            })),
                                    D(i.element)
                                        .closest(".modal")
                                        .on("hide.bs.modal", function () {
                                            return i.hide();
                                        });
                            }),
                                this.config.selector ? (this.config = D.extend({}, this.config, { trigger: "manual", selector: "" })) : this._fixTitle();
                        }),
                        (e._fixTitle = function () {
                            var e = typeof this.element.getAttribute("data-original-title");
                            (!this.element.getAttribute("title") && "string" == e) || (this.element.setAttribute("data-original-title", this.element.getAttribute("title") || ""), this.element.setAttribute("title", ""));
                        }),
                        (e._enter = function (e, t) {
                            var i = this.constructor.DATA_KEY;
                            (t = t || D(e.currentTarget).data(i)) || ((t = new this.constructor(e.currentTarget, this._getDelegateConfig())), D(e.currentTarget).data(i, t)),
                            e && (t._activeTrigger["focusin" === e.type ? v : m] = !0),
                                D(t.getTipElement()).hasClass(h) || t._hoverState === l
                                    ? (t._hoverState = l)
                                    : (clearTimeout(t._timeout),
                                        (t._hoverState = l),
                                        t.config.delay && t.config.delay.show
                                            ? (t._timeout = setTimeout(function () {
                                                t._hoverState === l && t.show();
                                            }, t.config.delay.show))
                                            : t.show());
                        }),
                        (e._leave = function (e, t) {
                            var i = this.constructor.DATA_KEY;
                            (t = t || D(e.currentTarget).data(i)) || ((t = new this.constructor(e.currentTarget, this._getDelegateConfig())), D(e.currentTarget).data(i, t)),
                            e && (t._activeTrigger["focusout" === e.type ? v : m] = !1),
                            t._isWithActiveTrigger() ||
                            (clearTimeout(t._timeout),
                                (t._hoverState = d),
                                t.config.delay && t.config.delay.hide
                                    ? (t._timeout = setTimeout(function () {
                                        t._hoverState === d && t.hide();
                                    }, t.config.delay.hide))
                                    : t.hide());
                        }),
                        (e._isWithActiveTrigger = function () {
                            for (var e in this._activeTrigger) if (this._activeTrigger[e]) return !0;
                            return !1;
                        }),
                        (e._getConfig = function (e) {
                            return (
                                "number" == typeof (e = D.extend({}, this.constructor.Default, D(this.element).data(), e)).delay && (e.delay = { show: e.delay, hide: e.delay }),
                                "number" == typeof e.title && (e.title = e.title.toString()),
                                "number" == typeof e.content && (e.content = e.content.toString()),
                                    O.typeCheckConfig(t, e, this.constructor.DefaultType),
                                    e
                            );
                        }),
                        (e._getDelegateConfig = function () {
                            var e = {};
                            if (this.config) for (var t in this.config) this.constructor.Default[t] !== this.config[t] && (e[t] = this.config[t]);
                            return e;
                        }),
                        (e._cleanTipClass = function () {
                            var e = D(this.getTipElement()),
                                t = e.attr("class").match(s);
                            null !== t && 0 < t.length && e.removeClass(t.join(""));
                        }),
                        (e._handlePopperPlacementChange = function (e) {
                            this._cleanTipClass(), this.addAttachmentClass(this._getAttachment(e.placement));
                        }),
                        (e._fixTransition = function () {
                            var e = this.getTipElement(),
                                t = this.config.animation;
                            null === e.getAttribute("x-placement") && (D(e).removeClass(u), (this.config.animation = !1), this.hide(), this.show(), (this.config.animation = t));
                        }),
                        (b._jQueryInterface = function (i) {
                            return this.each(function () {
                                var e = D(this).data("bs.tooltip"),
                                    t = "object" == typeof i && i;
                                if ((e || !/dispose|hide/.test(i)) && (e || ((e = new b(this, t)), D(this).data("bs.tooltip", e)), "string" == typeof i)) {
                                    if (void 0 === e[i]) throw new Error('No method named "' + i + '"');
                                    e[i]();
                                }
                            });
                        }),
                        M(b, null, [
                            {
                                key: "VERSION",
                                get: function () {
                                    return "4.0.0-beta.2";
                                },
                            },
                            {
                                key: "Default",
                                get: function () {
                                    return r;
                                },
                            },
                            {
                                key: "NAME",
                                get: function () {
                                    return t;
                                },
                            },
                            {
                                key: "DATA_KEY",
                                get: function () {
                                    return "bs.tooltip";
                                },
                            },
                            {
                                key: "Event",
                                get: function () {
                                    return c;
                                },
                            },
                            {
                                key: "EVENT_KEY",
                                get: function () {
                                    return i;
                                },
                            },
                            {
                                key: "DefaultType",
                                get: function () {
                                    return a;
                                },
                            },
                        ]),
                        b);
            function b(e, t) {
                (this._isEnabled = !0), (this._timeout = 0), (this._hoverState = ""), (this._activeTrigger = {}), (this._popper = null), (this.element = e), (this.config = this._getConfig(t)), (this.tip = null), this._setListeners();
            }
            return (
                (D.fn[t] = y._jQueryInterface),
                    (D.fn[t].Constructor = y),
                    (D.fn[t].noConflict = function () {
                        return (D.fn[t] = n), y._jQueryInterface;
                    }),
                    y
            );
        })(),
        u = (function () {
            var s = "popover",
                a = ".bs.popover",
                e = D.fn[s],
                o = new RegExp("(^|\\s)bs-popover\\S+", "g"),
                r = D.extend({}, f.Default, {
                    placement: "right",
                    trigger: "click",
                    content: "",
                    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                }),
                l = D.extend({}, f.DefaultType, { content: "(string|element|function)" }),
                d = "fade",
                c = "show",
                u = ".popover-header",
                h = ".popover-body",
                p = {
                    HIDE: "hide" + a,
                    HIDDEN: "hidden" + a,
                    SHOW: "show" + a,
                    SHOWN: "shown" + a,
                    INSERTED: "inserted" + a,
                    CLICK: "click" + a,
                    FOCUSIN: "focusin" + a,
                    FOCUSOUT: "focusout" + a,
                    MOUSEENTER: "mouseenter" + a,
                    MOUSELEAVE: "mouseleave" + a,
                },
                t = (function (e) {
                    function n() {
                        return e.apply(this, arguments) || this;
                    }
                    var t;
                    (i = e), ((t = n).prototype = Object.create(i.prototype)), ((t.prototype.constructor = t).__proto__ = i);
                    var i = n.prototype;
                    return (
                        (i.isWithContent = function () {
                            return this.getTitle() || this._getContent();
                        }),
                            (i.addAttachmentClass = function (e) {
                                D(this.getTipElement()).addClass("bs-popover-" + e);
                            }),
                            (i.getTipElement = function () {
                                return (this.tip = this.tip || D(this.config.template)[0]), this.tip;
                            }),
                            (i.setContent = function () {
                                var e = D(this.getTipElement());
                                this.setElementContent(e.find(u), this.getTitle()), this.setElementContent(e.find(h), this._getContent()), e.removeClass(d + " " + c);
                            }),
                            (i._getContent = function () {
                                return this.element.getAttribute("data-content") || ("function" == typeof this.config.content ? this.config.content.call(this.element) : this.config.content);
                            }),
                            (i._cleanTipClass = function () {
                                var e = D(this.getTipElement()),
                                    t = e.attr("class").match(o);
                                null !== t && 0 < t.length && e.removeClass(t.join(""));
                            }),
                            (n._jQueryInterface = function (i) {
                                return this.each(function () {
                                    var e = D(this).data("bs.popover"),
                                        t = "object" == typeof i ? i : null;
                                    if ((e || !/destroy|hide/.test(i)) && (e || ((e = new n(this, t)), D(this).data("bs.popover", e)), "string" == typeof i)) {
                                        if (void 0 === e[i]) throw new Error('No method named "' + i + '"');
                                        e[i]();
                                    }
                                });
                            }),
                            M(n, null, [
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.0.0-beta.2";
                                    },
                                },
                                {
                                    key: "Default",
                                    get: function () {
                                        return r;
                                    },
                                },
                                {
                                    key: "NAME",
                                    get: function () {
                                        return s;
                                    },
                                },
                                {
                                    key: "DATA_KEY",
                                    get: function () {
                                        return "bs.popover";
                                    },
                                },
                                {
                                    key: "Event",
                                    get: function () {
                                        return p;
                                    },
                                },
                                {
                                    key: "EVENT_KEY",
                                    get: function () {
                                        return a;
                                    },
                                },
                                {
                                    key: "DefaultType",
                                    get: function () {
                                        return l;
                                    },
                                },
                            ]),
                            n
                    );
                })(f);
            return (
                (D.fn[s] = t._jQueryInterface),
                    (D.fn[s].Constructor = t),
                    (D.fn[s].noConflict = function () {
                        return (D.fn[s] = e), t._jQueryInterface;
                    }),
                    t
            );
        })(),
        h = (function () {
            var e,
                i = "scrollspy",
                t = D.fn[i],
                n = { offset: 10, method: "auto", target: "" },
                s = { offset: "number", method: "string", target: "(string|element)" },
                a = "activate.bs.scrollspy",
                o = "scroll.bs.scrollspy",
                r = "load.bs.scrollspy.data-api",
                l = "dropdown-item",
                d = "active",
                c = '[data-spy="scroll"]',
                u = ".active",
                h = ".nav, .list-group",
                p = ".nav-link",
                f = ".nav-item",
                m = ".list-group-item",
                v = ".dropdown",
                g = ".dropdown-item",
                w = ".dropdown-toggle",
                y = "offset",
                b = "position",
                _ =
                    (((e = k.prototype).refresh = function () {
                        var t = this,
                            e = this._scrollElement !== this._scrollElement.window ? b : y,
                            n = "auto" === this._config.method ? e : this._config.method,
                            s = n === b ? this._getScrollTop() : 0;
                        (this._offsets = []),
                            (this._targets = []),
                            (this._scrollHeight = this._getScrollHeight()),
                            D.makeArray(D(this._selector))
                                .map(function (e) {
                                    var t,
                                        i = O.getSelectorFromElement(e);
                                    if ((i && (t = D(i)[0]), t)) {
                                        e = t.getBoundingClientRect();
                                        if (e.width || e.height) return [D(t)[n]().top + s, i];
                                    }
                                    return null;
                                })
                                .filter(function (e) {
                                    return e;
                                })
                                .sort(function (e, t) {
                                    return e[0] - t[0];
                                })
                                .forEach(function (e) {
                                    t._offsets.push(e[0]), t._targets.push(e[1]);
                                });
                    }),
                        (e.dispose = function () {
                            D.removeData(this._element, "bs.scrollspy"),
                                D(this._scrollElement).off(".bs.scrollspy"),
                                (this._element = null),
                                (this._scrollElement = null),
                                (this._config = null),
                                (this._selector = null),
                                (this._offsets = null),
                                (this._targets = null),
                                (this._activeTarget = null),
                                (this._scrollHeight = null);
                        }),
                        (e._getConfig = function (e) {
                            var t;
                            return "string" != typeof (e = D.extend({}, n, e)).target && ((t = D(e.target).attr("id")) || ((t = O.getUID(i)), D(e.target).attr("id", t)), (e.target = "#" + t)), O.typeCheckConfig(i, e, s), e;
                        }),
                        (e._getScrollTop = function () {
                            return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop;
                        }),
                        (e._getScrollHeight = function () {
                            return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
                        }),
                        (e._getOffsetHeight = function () {
                            return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height;
                        }),
                        (e._process = function () {
                            var e = this._getScrollTop() + this._config.offset,
                                t = this._getScrollHeight(),
                                i = this._config.offset + t - this._getOffsetHeight();
                            if ((this._scrollHeight !== t && this.refresh(), i <= e)) {
                                i = this._targets[this._targets.length - 1];
                                this._activeTarget !== i && this._activate(i);
                            } else {
                                if (this._activeTarget && e < this._offsets[0] && 0 < this._offsets[0]) return (this._activeTarget = null), void this._clear();
                                for (var n = this._offsets.length; n--; ) this._activeTarget !== this._targets[n] && e >= this._offsets[n] && (void 0 === this._offsets[n + 1] || e < this._offsets[n + 1]) && this._activate(this._targets[n]);
                            }
                        }),
                        (e._activate = function (t) {
                            (this._activeTarget = t), this._clear();
                            var e = (e = this._selector.split(",")).map(function (e) {
                                    return e + '[data-target="' + t + '"],' + e + '[href="' + t + '"]';
                                }),
                                e = D(e.join(","));
                            e.hasClass(l)
                                ? (e.closest(v).find(w).addClass(d), e.addClass(d))
                                : (e.addClass(d),
                                    e
                                        .parents(h)
                                        .prev(p + ", " + m)
                                        .addClass(d),
                                    e.parents(h).prev(f).children(p).addClass(d)),
                                D(this._scrollElement).trigger(a, { relatedTarget: t });
                        }),
                        (e._clear = function () {
                            D(this._selector).filter(u).removeClass(d);
                        }),
                        (k._jQueryInterface = function (t) {
                            return this.each(function () {
                                var e = D(this).data("bs.scrollspy");
                                if ((e || ((e = new k(this, "object" == typeof t && t)), D(this).data("bs.scrollspy", e)), "string" == typeof t)) {
                                    if (void 0 === e[t]) throw new Error('No method named "' + t + '"');
                                    e[t]();
                                }
                            });
                        }),
                        M(k, null, [
                            {
                                key: "VERSION",
                                get: function () {
                                    return "4.0.0-beta.2";
                                },
                            },
                            {
                                key: "Default",
                                get: function () {
                                    return n;
                                },
                            },
                        ]),
                        k);
            function k(e, t) {
                var i = this;
                (this._element = e),
                    (this._scrollElement = "BODY" === e.tagName ? window : e),
                    (this._config = this._getConfig(t)),
                    (this._selector = this._config.target + " " + p + "," + this._config.target + " " + m + "," + this._config.target + " " + g),
                    (this._offsets = []),
                    (this._targets = []),
                    (this._activeTarget = null),
                    (this._scrollHeight = 0),
                    D(this._scrollElement).on(o, function (e) {
                        return i._process(e);
                    }),
                    this.refresh(),
                    this._process();
            }
            return (
                D(window).on(r, function () {
                    for (var e = D.makeArray(D(c)), t = e.length; t--; ) {
                        var i = D(e[t]);
                        _._jQueryInterface.call(i, i.data());
                    }
                }),
                    (D.fn[i] = _._jQueryInterface),
                    (D.fn[i].Constructor = _),
                    (D.fn[i].noConflict = function () {
                        return (D.fn[i] = t), _._jQueryInterface;
                    }),
                    _
            );
        })(),
        p = (function () {
            var e,
                t = D.fn.tab,
                r = "hide.bs.tab",
                l = "hidden.bs.tab",
                d = "show.bs.tab",
                c = "shown.bs.tab",
                i = "click.bs.tab.data-api",
                a = "dropdown-menu",
                u = "active",
                h = "disabled",
                o = "fade",
                p = "show",
                f = ".dropdown",
                m = ".nav, .list-group",
                v = ".active",
                g = "> li > .active",
                n = '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]',
                w = ".dropdown-toggle",
                y = "> .dropdown-menu .active",
                s =
                    (((e = b.prototype).show = function () {
                        var e,
                            t,
                            i,
                            n,
                            s,
                            a,
                            o = this;
                        (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && D(this._element).hasClass(u)) ||
                        D(this._element).hasClass(h) ||
                        ((a = D(this._element).closest(m)[0]),
                            (t = O.getSelectorFromElement(this._element)),
                        a && ((s = "UL" === a.nodeName ? g : v), (i = (i = D.makeArray(D(a).find(s)))[i.length - 1])),
                            (n = D.Event(r, { relatedTarget: this._element })),
                            (s = D.Event(d, { relatedTarget: i })),
                        i && D(i).trigger(n),
                            D(this._element).trigger(s),
                        s.isDefaultPrevented() ||
                        n.isDefaultPrevented() ||
                        (t && (e = D(t)[0]),
                            this._activate(this._element, a),
                            (a = function () {
                                var e = D.Event(l, { relatedTarget: o._element }),
                                    t = D.Event(c, { relatedTarget: i });
                                D(i).trigger(e), D(o._element).trigger(t);
                            }),
                            e ? this._activate(e, e.parentNode, a) : a()));
                    }),
                        (e.dispose = function () {
                            D.removeData(this._element, "bs.tab"), (this._element = null);
                        }),
                        (e._activate = function (e, t, i) {
                            var n = this,
                                s = ("UL" === t.nodeName ? D(t).find(g) : D(t).children(v))[0],
                                a = i && O.supportsTransitionEnd() && s && D(s).hasClass(o),
                                t = function () {
                                    return n._transitionComplete(e, s, a, i);
                                };
                            s && a ? D(s).one(O.TRANSITION_END, t).emulateTransitionEnd(150) : t(), s && D(s).removeClass(p);
                        }),
                        (e._transitionComplete = function (e, t, i, n) {
                            var s;
                            t && (D(t).removeClass(u), (s = D(t.parentNode).find(y)[0]) && D(s).removeClass(u), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !1)),
                                D(e).addClass(u),
                            "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !0),
                                i ? (O.reflow(e), D(e).addClass(p)) : D(e).removeClass(o),
                            e.parentNode && D(e.parentNode).hasClass(a) && ((i = D(e).closest(f)[0]) && D(i).find(w).addClass(u), e.setAttribute("aria-expanded", !0)),
                            n && n();
                        }),
                        (b._jQueryInterface = function (i) {
                            return this.each(function () {
                                var e = D(this),
                                    t = e.data("bs.tab");
                                if ((t || ((t = new b(this)), e.data("bs.tab", t)), "string" == typeof i)) {
                                    if (void 0 === t[i]) throw new Error('No method named "' + i + '"');
                                    t[i]();
                                }
                            });
                        }),
                        M(b, null, [
                            {
                                key: "VERSION",
                                get: function () {
                                    return "4.0.0-beta.2";
                                },
                            },
                        ]),
                        b);
            function b(e) {
                this._element = e;
            }
            return (
                D(document).on(i, n, function (e) {
                    e.preventDefault(), s._jQueryInterface.call(D(this), "show");
                }),
                    (D.fn.tab = s._jQueryInterface),
                    (D.fn.tab.Constructor = s),
                    (D.fn.tab.noConflict = function () {
                        return (D.fn.tab = t), s._jQueryInterface;
                    }),
                    s
            );
        })();
    return (
        (function () {
            if (void 0 === D) throw new Error("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");
            var e = D.fn.jquery.split(" ")[0].split(".");
            if ((e[0] < 2 && e[1] < 9) || (1 === e[0] && 9 === e[1] && e[2] < 1) || 4 <= e[0]) throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0");
        })(),
            (e.Util = O),
            (e.Alert = s),
            (e.Button = a),
            (e.Carousel = o),
            (e.Collapse = l),
            (e.Dropdown = d),
            (e.Modal = c),
            (e.Popover = u),
            (e.Scrollspy = h),
            (e.Tab = p),
            (e.Tooltip = f),
            e
    );
})({}, $, Popper);
!(function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? (module.exports = t()) : "function" == typeof define && define.amd ? define(t) : (e.Swiper = t());
})(this, function () {
    "use strict";
    var e =
            "undefined" == typeof document
                ? {
                    body: {},
                    addEventListener: function () {},
                    removeEventListener: function () {},
                    activeElement: { blur: function () {}, nodeName: "" },
                    querySelector: function () {
                        return null;
                    },
                    querySelectorAll: function () {
                        return [];
                    },
                    getElementById: function () {
                        return null;
                    },
                    createEvent: function () {
                        return { initEvent: function () {} };
                    },
                    createElement: function () {
                        return {
                            children: [],
                            childNodes: [],
                            style: {},
                            setAttribute: function () {},
                            getElementsByTagName: function () {
                                return [];
                            },
                        };
                    },
                    location: { hash: "" },
                }
                : document,
        u = e,
        t =
            "undefined" == typeof window
                ? {
                    document: u,
                    navigator: { userAgent: "" },
                    location: {},
                    history: {},
                    CustomEvent: function () {
                        return this;
                    },
                    addEventListener: function () {},
                    removeEventListener: function () {},
                    getComputedStyle: function () {
                        return {
                            getPropertyValue: function () {
                                return "";
                            },
                        };
                    },
                    Image: function () {},
                    Date: function () {},
                    screen: {},
                    setTimeout: function () {},
                    clearTimeout: function () {},
                }
                : window,
        c = t,
        l = function (e) {
            for (var t = 0; t < e.length; t += 1) this[t] = e[t];
            return (this.length = e.length), this;
        };
    function x(e, t) {
        var i = [],
            n = 0;
        if (e && !t && e instanceof l) return e;
        if (e)
            if ("string" == typeof e) {
                var s,
                    a,
                    o = e.trim();
                if (0 <= o.indexOf("<") && 0 <= o.indexOf(">")) {
                    var r = "div";
                    for (
                        0 === o.indexOf("<li") && (r = "ul"),
                        0 === o.indexOf("<tr") && (r = "tbody"),
                        (0 !== o.indexOf("<td") && 0 !== o.indexOf("<th")) || (r = "tr"),
                        0 === o.indexOf("<tbody") && (r = "table"),
                        0 === o.indexOf("<option") && (r = "select"),
                            (a = u.createElement(r)).innerHTML = o,
                            n = 0;
                        n < a.childNodes.length;
                        n += 1
                    )
                        i.push(a.childNodes[n]);
                } else for (s = t || "#" !== e[0] || e.match(/[ .<>:~]/) ? (t || u).querySelectorAll(e.trim()) : [u.getElementById(e.trim().split("#")[1])], n = 0; n < s.length; n += 1) s[n] && i.push(s[n]);
            } else if (e.nodeType || e === c || e === u) i.push(e);
            else if (0 < e.length && e[0].nodeType) for (n = 0; n < e.length; n += 1) i.push(e[n]);
        return new l(i);
    }
    function a(e) {
        for (var t = [], i = 0; i < e.length; i += 1) -1 === t.indexOf(e[i]) && t.push(e[i]);
        return t;
    }
    (x.fn = l.prototype), (x.Class = l), (x.Dom7 = l);
    "resize scroll".split(" ");
    var i = {
        addClass: function (e) {
            if (void 0 === e) return this;
            for (var t = e.split(" "), i = 0; i < t.length; i += 1) for (var n = 0; n < this.length; n += 1) void 0 !== this[n].classList && this[n].classList.add(t[i]);
            return this;
        },
        removeClass: function (e) {
            for (var t = e.split(" "), i = 0; i < t.length; i += 1) for (var n = 0; n < this.length; n += 1) void 0 !== this[n].classList && this[n].classList.remove(t[i]);
            return this;
        },
        hasClass: function (e) {
            return !!this[0] && this[0].classList.contains(e);
        },
        toggleClass: function (e) {
            for (var t = e.split(" "), i = 0; i < t.length; i += 1) for (var n = 0; n < this.length; n += 1) void 0 !== this[n].classList && this[n].classList.toggle(t[i]);
            return this;
        },
        attr: function (e, t) {
            var i = arguments;
            if (1 === arguments.length && "string" == typeof e) return this[0] ? this[0].getAttribute(e) : void 0;
            for (var n = 0; n < this.length; n += 1)
                if (2 === i.length) this[n].setAttribute(e, t);
                else for (var s in e) (this[n][s] = e[s]), this[n].setAttribute(s, e[s]);
            return this;
        },
        removeAttr: function (e) {
            for (var t = 0; t < this.length; t += 1) this[t].removeAttribute(e);
            return this;
        },
        data: function (e, t) {
            var i;
            if (void 0 !== t) {
                for (var n = 0; n < this.length; n += 1) (i = this[n]).dom7ElementDataStorage || (i.dom7ElementDataStorage = {}), (i.dom7ElementDataStorage[e] = t);
                return this;
            }
            if ((i = this[0])) {
                if (i.dom7ElementDataStorage && e in i.dom7ElementDataStorage) return i.dom7ElementDataStorage[e];
                var s = i.getAttribute("data-" + e);
                return s ? s : void 0;
            }
        },
        transform: function (e) {
            for (var t = 0; t < this.length; t += 1) {
                var i = this[t].style;
                (i.webkitTransform = e), (i.transform = e);
            }
            return this;
        },
        transition: function (e) {
            "string" != typeof e && (e += "ms");
            for (var t = 0; t < this.length; t += 1) {
                var i = this[t].style;
                (i.webkitTransitionDuration = e), (i.transitionDuration = e);
            }
            return this;
        },
        on: function () {
            for (var e = [], t = arguments.length; t--; ) e[t] = arguments[t];
            var i = e[0],
                a = e[1],
                o = e[2],
                n = e[3];
            function s(e) {
                var t = e.target;
                if (t) {
                    var i = e.target.dom7EventData || [];
                    if ((i.unshift(e), x(t).is(a))) o.apply(t, i);
                    else for (var n = x(t).parents(), s = 0; s < n.length; s += 1) x(n[s]).is(a) && o.apply(n[s], i);
                }
            }
            function r(e) {
                var t = (e && e.target && e.target.dom7EventData) || [];
                t.unshift(e), o.apply(this, t);
            }
            "function" == typeof e[1] && ((i = e[0]), (o = e[1]), (n = e[2]), (a = void 0)), (n = n || !1);
            for (var l, d = i.split(" "), c = 0; c < this.length; c += 1) {
                var u = this[c];
                if (a) for (l = 0; l < d.length; l += 1) u.dom7LiveListeners || (u.dom7LiveListeners = []), u.dom7LiveListeners.push({ type: i, listener: o, proxyListener: s }), u.addEventListener(d[l], s, n);
                else for (l = 0; l < d.length; l += 1) u.dom7Listeners || (u.dom7Listeners = []), u.dom7Listeners.push({ type: i, listener: o, proxyListener: r }), u.addEventListener(d[l], r, n);
            }
            return this;
        },
        off: function () {
            for (var e = [], t = arguments.length; t--; ) e[t] = arguments[t];
            var i = e[0],
                n = e[1],
                s = e[2],
                a = e[3];
            "function" == typeof e[1] && ((i = e[0]), (s = e[1]), (a = e[2]), (n = void 0)), (a = a || !1);
            for (var o = i.split(" "), r = 0; r < o.length; r += 1)
                for (var l = 0; l < this.length; l += 1) {
                    var d = this[l];
                    if (n) {
                        if (d.dom7LiveListeners)
                            for (var c = 0; c < d.dom7LiveListeners.length; c += 1)
                                s
                                    ? d.dom7LiveListeners[c].listener === s && d.removeEventListener(o[r], d.dom7LiveListeners[c].proxyListener, a)
                                    : d.dom7LiveListeners[c].type === o[r] && d.removeEventListener(o[r], d.dom7LiveListeners[c].proxyListener, a);
                    } else if (d.dom7Listeners)
                        for (var u = 0; u < d.dom7Listeners.length; u += 1)
                            s ? d.dom7Listeners[u].listener === s && d.removeEventListener(o[r], d.dom7Listeners[u].proxyListener, a) : d.dom7Listeners[u].type === o[r] && d.removeEventListener(o[r], d.dom7Listeners[u].proxyListener, a);
                }
            return this;
        },
        trigger: function () {
            for (var e = [], t = arguments.length; t--; ) e[t] = arguments[t];
            for (var i = e[0].split(" "), n = e[1], s = 0; s < i.length; s += 1)
                for (var a = 0; a < this.length; a += 1) {
                    var o = void 0;
                    try {
                        o = new c.CustomEvent(i[s], { detail: n, bubbles: !0, cancelable: !0 });
                    } catch (e) {
                        (o = u.createEvent("Event")).initEvent(i[s], !0, !0), (o.detail = n);
                    }
                    (this[a].dom7EventData = e.filter(function (e, t) {
                        return 0 < t;
                    })),
                        this[a].dispatchEvent(o),
                        (this[a].dom7EventData = []),
                        delete this[a].dom7EventData;
                }
            return this;
        },
        transitionEnd: function (t) {
            var i,
                n = ["webkitTransitionEnd", "transitionend"],
                s = this;
            function a(e) {
                if (e.target === this) for (t.call(this, e), i = 0; i < n.length; i += 1) s.off(n[i], a);
            }
            if (t) for (i = 0; i < n.length; i += 1) s.on(n[i], a);
            return this;
        },
        outerWidth: function (e) {
            if (0 < this.length) {
                if (e) {
                    e = this.styles();
                    return this[0].offsetWidth + parseFloat(e.getPropertyValue("margin-right")) + parseFloat(e.getPropertyValue("margin-left"));
                }
                return this[0].offsetWidth;
            }
            return null;
        },
        outerHeight: function (e) {
            if (0 < this.length) {
                if (e) {
                    e = this.styles();
                    return this[0].offsetHeight + parseFloat(e.getPropertyValue("margin-top")) + parseFloat(e.getPropertyValue("margin-bottom"));
                }
                return this[0].offsetHeight;
            }
            return null;
        },
        offset: function () {
            if (0 < this.length) {
                var e = this[0],
                    t = e.getBoundingClientRect(),
                    i = u.body,
                    n = e.clientTop || i.clientTop || 0,
                    s = e.clientLeft || i.clientLeft || 0,
                    i = e === c ? c.scrollY : e.scrollTop,
                    e = e === c ? c.scrollX : e.scrollLeft;
                return { top: t.top + i - n, left: t.left + e - s };
            }
            return null;
        },
        css: function (e, t) {
            var i;
            if (1 === arguments.length) {
                if ("string" != typeof e) {
                    for (i = 0; i < this.length; i += 1) for (var n in e) this[i].style[n] = e[n];
                    return this;
                }
                if (this[0]) return c.getComputedStyle(this[0], null).getPropertyValue(e);
            }
            if (2 !== arguments.length || "string" != typeof e) return this;
            for (i = 0; i < this.length; i += 1) this[i].style[e] = t;
            return this;
        },
        each: function (e) {
            if (!e) return this;
            for (var t = 0; t < this.length; t += 1) if (!1 === e.call(this[t], t, this[t])) return this;
            return this;
        },
        html: function (e) {
            if (void 0 === e) return this[0] ? this[0].innerHTML : void 0;
            for (var t = 0; t < this.length; t += 1) this[t].innerHTML = e;
            return this;
        },
        text: function (e) {
            if (void 0 === e) return this[0] ? this[0].textContent.trim() : null;
            for (var t = 0; t < this.length; t += 1) this[t].textContent = e;
            return this;
        },
        is: function (e) {
            var t,
                i,
                n = this[0];
            if (!n || void 0 === e) return !1;
            if ("string" == typeof e) {
                if (n.matches) return n.matches(e);
                if (n.webkitMatchesSelector) return n.webkitMatchesSelector(e);
                if (n.msMatchesSelector) return n.msMatchesSelector(e);
                for (t = x(e), i = 0; i < t.length; i += 1) if (t[i] === n) return !0;
                return !1;
            }
            if (e === u) return n === u;
            if (e === c) return n === c;
            if (e.nodeType || e instanceof l) {
                for (t = e.nodeType ? [e] : e, i = 0; i < t.length; i += 1) if (t[i] === n) return !0;
                return !1;
            }
            return !1;
        },
        index: function () {
            var e,
                t = this[0];
            if (t) {
                for (e = 0; null !== (t = t.previousSibling); ) 1 === t.nodeType && (e += 1);
                return e;
            }
        },
        eq: function (e) {
            if (void 0 === e) return this;
            var t = this.length;
            return new l(t - 1 < e ? [] : e < 0 ? ((t = t + e) < 0 ? [] : [this[t]]) : [this[e]]);
        },
        append: function () {
            for (var e, t = [], i = arguments.length; i--; ) t[i] = arguments[i];
            for (var n = 0; n < t.length; n += 1) {
                e = t[n];
                for (var s = 0; s < this.length; s += 1)
                    if ("string" == typeof e) {
                        var a = u.createElement("div");
                        for (a.innerHTML = e; a.firstChild; ) this[s].appendChild(a.firstChild);
                    } else if (e instanceof l) for (var o = 0; o < e.length; o += 1) this[s].appendChild(e[o]);
                    else this[s].appendChild(e);
            }
            return this;
        },
        prepend: function (e) {
            for (var t, i = this, n = 0; n < this.length; n += 1)
                if ("string" == typeof e) {
                    var s = u.createElement("div");
                    for (s.innerHTML = e, t = s.childNodes.length - 1; 0 <= t; --t) i[n].insertBefore(s.childNodes[t], i[n].childNodes[0]);
                } else if (e instanceof l) for (t = 0; t < e.length; t += 1) i[n].insertBefore(e[t], i[n].childNodes[0]);
                else i[n].insertBefore(e, i[n].childNodes[0]);
            return this;
        },
        next: function (e) {
            return 0 < this.length
                ? e
                    ? this[0].nextElementSibling && x(this[0].nextElementSibling).is(e)
                        ? new l([this[0].nextElementSibling])
                        : new l([])
                    : this[0].nextElementSibling
                        ? new l([this[0].nextElementSibling])
                        : new l([])
                : new l([]);
        },
        nextAll: function (e) {
            var t = [],
                i = this[0];
            if (!i) return new l([]);
            for (; i.nextElementSibling; ) {
                var n = i.nextElementSibling;
                (!e || x(n).is(e)) && t.push(n), (i = n);
            }
            return new l(t);
        },
        prev: function (e) {
            if (0 < this.length) {
                var t = this[0];
                return e ? (t.previousElementSibling && x(t.previousElementSibling).is(e) ? new l([t.previousElementSibling]) : new l([])) : t.previousElementSibling ? new l([t.previousElementSibling]) : new l([]);
            }
            return new l([]);
        },
        prevAll: function (e) {
            var t = [],
                i = this[0];
            if (!i) return new l([]);
            for (; i.previousElementSibling; ) {
                var n = i.previousElementSibling;
                (!e || x(n).is(e)) && t.push(n), (i = n);
            }
            return new l(t);
        },
        parent: function (e) {
            for (var t = [], i = 0; i < this.length; i += 1) null === this[i].parentNode || (e && !x(this[i].parentNode).is(e)) || t.push(this[i].parentNode);
            return x(a(t));
        },
        parents: function (e) {
            for (var t = [], i = 0; i < this.length; i += 1) for (var n = this[i].parentNode; n; ) (e && !x(n).is(e)) || t.push(n), (n = n.parentNode);
            return x(a(t));
        },
        closest: function (e) {
            var t = this;
            return void 0 === e ? new l([]) : (t.is(e) || (t = t.parents(e).eq(0)), t);
        },
        find: function (e) {
            for (var t = [], i = 0; i < this.length; i += 1) for (var n = this[i].querySelectorAll(e), s = 0; s < n.length; s += 1) t.push(n[s]);
            return new l(t);
        },
        children: function (e) {
            for (var t = [], i = 0; i < this.length; i += 1) for (var n = this[i].childNodes, s = 0; s < n.length; s += 1) e ? 1 === n[s].nodeType && x(n[s]).is(e) && t.push(n[s]) : 1 === n[s].nodeType && t.push(n[s]);
            return new l(a(t));
        },
        remove: function () {
            for (var e = 0; e < this.length; e += 1) this[e].parentNode && this[e].parentNode.removeChild(this[e]);
            return this;
        },
        add: function () {
            for (var e = [], t = arguments.length; t--; ) e[t] = arguments[t];
            for (var i = 0; i < e.length; i += 1) for (var n = x(e[i]), s = 0; s < n.length; s += 1) (this[this.length] = n[s]), (this.length += 1);
            return this;
        },
        styles: function () {
            return this[0] ? c.getComputedStyle(this[0], null) : {};
        },
    };
    Object.keys(i).forEach(function (e) {
        x.fn[e] = i[e];
    });
    var n,
        P = {
            deleteProps: function (e) {
                var t = e;
                Object.keys(t).forEach(function (e) {
                    try {
                        t[e] = null;
                    } catch (e) {}
                    try {
                        delete t[e];
                    } catch (e) {}
                });
            },
            nextTick: function (e, t) {
                return void 0 === t && (t = 0), setTimeout(e, t);
            },
            now: function () {
                return Date.now();
            },
            getTranslate: function (e, t) {
                var i, n, s;
                void 0 === t && (t = "x");
                e = c.getComputedStyle(e, null);
                return (
                    c.WebKitCSSMatrix
                        ? (6 < (n = e.transform || e.webkitTransform).split(",").length &&
                        (n = n
                            .split(", ")
                            .map(function (e) {
                                return e.replace(",", ".");
                            })
                            .join(", ")),
                            (s = new c.WebKitCSSMatrix("none" === n ? "" : n)))
                        : (i = (s = e.MozTransform || e.OTransform || e.MsTransform || e.msTransform || e.transform || e.getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,")).toString().split(",")),
                    "x" === t && (n = c.WebKitCSSMatrix ? s.m41 : 16 === i.length ? parseFloat(i[12]) : parseFloat(i[4])),
                    "y" === t && (n = c.WebKitCSSMatrix ? s.m42 : 16 === i.length ? parseFloat(i[13]) : parseFloat(i[5])),
                    n || 0
                );
            },
            parseUrlQuery: function (e) {
                var t,
                    i,
                    n,
                    s,
                    a = {},
                    e = e || c.location.href;
                if ("string" == typeof e && e.length)
                    for (
                        s = (i = (e = -1 < e.indexOf("?") ? e.replace(/\S*\?/, "") : "").split("&").filter(function (e) {
                            return "" !== e;
                        })).length,
                            t = 0;
                        t < s;
                        t += 1
                    )
                        (n = i[t].replace(/#\S+/g, "").split("=")), (a[decodeURIComponent(n[0])] = void 0 === n[1] ? void 0 : decodeURIComponent(n[1]) || "");
                return a;
            },
            isObject: function (e) {
                return "object" == typeof e && null !== e && e.constructor && e.constructor === Object;
            },
            extend: function () {
                for (var e = [], t = arguments.length; t--; ) e[t] = arguments[t];
                for (var i = Object(e[0]), n = 1; n < e.length; n += 1) {
                    var s = e[n];
                    if (null != s)
                        for (var a = Object.keys(Object(s)), o = 0, r = a.length; o < r; o += 1) {
                            var l = a[o],
                                d = Object.getOwnPropertyDescriptor(s, l);
                            void 0 !== d && d.enumerable && (P.isObject(i[l]) && P.isObject(s[l]) ? P.extend(i[l], s[l]) : !P.isObject(i[l]) && P.isObject(s[l]) ? ((i[l] = {}), P.extend(i[l], s[l])) : (i[l] = s[l]));
                        }
                }
                return i;
            },
        },
        A =
            ((n = u.createElement("div")),
                {
                    touch: (c.Modernizr && !0 === c.Modernizr.touch) || !!("ontouchstart" in c || (c.DocumentTouch && u instanceof c.DocumentTouch)),
                    pointerEvents: !(!c.navigator.pointerEnabled && !c.PointerEvent),
                    prefixedPointerEvents: !!c.navigator.msPointerEnabled,
                    transition: "transition" in (h = n.style) || "webkitTransition" in h || "MozTransition" in h,
                    transforms3d: (c.Modernizr && !0 === c.Modernizr.csstransforms3d) || "webkitPerspective" in (h = n.style) || "MozPerspective" in h || "OPerspective" in h || "MsPerspective" in h || "perspective" in h,
                    flexbox: (function () {
                        for (
                            var e = n.style, t = "alignItems webkitAlignItems webkitBoxAlign msFlexAlign mozBoxAlign webkitFlexDirection msFlexDirection mozBoxDirection mozBoxOrient webkitBoxDirection webkitBoxOrient".split(" "), i = 0;
                            i < t.length;
                            i += 1
                        )
                            if (t[i] in e) return !0;
                        return !1;
                    })(),
                    observer: "MutationObserver" in c || "WebkitMutationObserver" in c,
                    passiveListener: (function () {
                        var e = !1;
                        try {
                            var t = Object.defineProperty({}, "passive", {
                                get: function () {
                                    e = !0;
                                },
                            });
                            c.addEventListener("testPassiveListener", null, t);
                        } catch (e) {}
                        return e;
                    })(),
                    gestures: "ongesturestart" in c,
                }),
        s = function (e) {
            void 0 === e && (e = {});
            var t = this;
            (t.params = e),
                (t.eventsListeners = {}),
            t.params &&
            t.params.on &&
            Object.keys(t.params.on).forEach(function (e) {
                t.on(e, t.params.on[e]);
            });
        },
        o = { components: { configurable: !0 } };
    (s.prototype.on = function (e, t) {
        var i = this;
        return (
            "function" != typeof t ||
            e.split(" ").forEach(function (e) {
                i.eventsListeners[e] || (i.eventsListeners[e] = []), i.eventsListeners[e].push(t);
            }),
                i
        );
    }),
        (s.prototype.once = function (n, s) {
            var a = this;
            return "function" != typeof s
                ? a
                : a.on(n, function e() {
                    for (var t = [], i = arguments.length; i--; ) t[i] = arguments[i];
                    s.apply(a, t), a.off(n, e);
                });
        }),
        (s.prototype.off = function (e, n) {
            var s = this;
            return (
                e.split(" ").forEach(function (i) {
                    void 0 === n
                        ? (s.eventsListeners[i] = [])
                        : s.eventsListeners[i].forEach(function (e, t) {
                            e === n && s.eventsListeners[i].splice(t, 1);
                        });
                }),
                    s
            );
        }),
        (s.prototype.emit = function () {
            for (var e = [], t = arguments.length; t--; ) e[t] = arguments[t];
            var i,
                n,
                s,
                a = this;
            return (
                a.eventsListeners &&
                ((s = "string" == typeof e[0] || Array.isArray(e[0]) ? ((i = e[0]), (n = e.slice(1, e.length)), a) : ((i = e[0].events), (n = e[0].data), e[0].context || a)),
                    (Array.isArray(i) ? i : i.split(" ")).forEach(function (e) {
                        var t;
                        a.eventsListeners[e] &&
                        ((t = []),
                            a.eventsListeners[e].forEach(function (e) {
                                t.push(e);
                            }),
                            t.forEach(function (e) {
                                e.apply(s, n);
                            }));
                    })),
                    a
            );
        }),
        (s.prototype.useModulesParams = function (t) {
            var i = this;
            i.modules &&
            Object.keys(i.modules).forEach(function (e) {
                e = i.modules[e];
                e.params && P.extend(t, e.params);
            });
        }),
        (s.prototype.useModules = function (t) {
            void 0 === t && (t = {});
            var n = this;
            n.modules &&
            Object.keys(n.modules).forEach(function (e) {
                var i = n.modules[e],
                    e = t[e] || {};
                i.instance &&
                Object.keys(i.instance).forEach(function (e) {
                    var t = i.instance[e];
                    n[e] = "function" == typeof t ? t.bind(n) : t;
                }),
                i.on &&
                n.on &&
                Object.keys(i.on).forEach(function (e) {
                    n.on(e, i.on[e]);
                }),
                i.create && i.create.bind(n)(e);
            });
        }),
        (o.components.set = function (e) {
            this.use && this.use(e);
        }),
        (s.installModule = function (t) {
            for (var e = [], i = arguments.length - 1; 0 < i--; ) e[i] = arguments[i + 1];
            var n = this;
            n.prototype.modules || (n.prototype.modules = {});
            var s = t.name || Object.keys(n.prototype.modules).length + "_" + P.now();
            return (
                (n.prototype.modules[s] = t).proto &&
                Object.keys(t.proto).forEach(function (e) {
                    n.prototype[e] = t.proto[e];
                }),
                t.static &&
                Object.keys(t.static).forEach(function (e) {
                    n[e] = t.static[e];
                }),
                t.install && t.install.apply(n, e),
                    n
            );
        }),
        (s.use = function (e) {
            for (var t = [], i = arguments.length - 1; 0 < i--; ) t[i] = arguments[i + 1];
            var n = this;
            return Array.isArray(e)
                ? (e.forEach(function (e) {
                    return n.installModule(e);
                }),
                    n)
                : n.installModule.apply(n, [e].concat(t));
        }),
        Object.defineProperties(s, o);
    function r() {
        var e,
            t,
            i = this,
            n = i.params,
            s = i.el;
        (s && 0 === s.offsetWidth) ||
        (n.breakpoints && i.setBreakpoint(),
            (e = i.allowSlideNext),
            (t = i.allowSlidePrev),
            (i.allowSlideNext = !0),
            (i.allowSlidePrev = !0),
            i.updateSize(),
            i.updateSlides(),
            n.freeMode
                ? ((s = Math.min(Math.max(i.translate, i.maxTranslate()), i.minTranslate())), i.setTranslate(s), i.updateActiveIndex(), i.updateSlidesClasses(), n.autoHeight && i.updateAutoHeight())
                : (i.updateSlidesClasses(), ("auto" === n.slidesPerView || 1 < n.slidesPerView) && i.isEnd && !i.params.centeredSlides ? i.slideTo(i.slides.length - 1, 0, !1, !0) : i.slideTo(i.activeIndex, 0, !1, !0)),
            (i.allowSlidePrev = t),
            (i.allowSlideNext = e));
    }
    var d,
        h,
        p = {
            updateSize: function () {
                var e = this,
                    t = e.$el,
                    i = void 0 !== e.params.width ? e.params.width : t[0].clientWidth,
                    n = void 0 !== e.params.height ? e.params.height : t[0].clientHeight;
                (0 === i && e.isHorizontal()) ||
                (0 === n && e.isVertical()) ||
                ((i = i - parseInt(t.css("padding-left"), 10) - parseInt(t.css("padding-right"), 10)),
                    (n = n - parseInt(t.css("padding-top"), 10) - parseInt(t.css("padding-bottom"), 10)),
                    P.extend(e, { width: i, height: n, size: e.isHorizontal() ? i : n }));
            },
            updateSlides: function () {
                var e = this,
                    t = e.params,
                    i = e.$wrapperEl,
                    n = e.size,
                    s = e.rtl,
                    a = e.wrongRTL,
                    o = i.children("." + e.params.slideClass),
                    r = (e.virtual && t.virtual.enabled ? e.virtual.slides : o).length,
                    l = [],
                    d = [],
                    c = [],
                    u = t.slidesOffsetBefore;
                "function" == typeof u && (u = t.slidesOffsetBefore.call(e));
                var h = t.slidesOffsetAfter;
                "function" == typeof h && (h = t.slidesOffsetAfter.call(e));
                var p,
                    f,
                    m = r,
                    v = e.snapGrid.length,
                    g = e.snapGrid.length,
                    w = t.spaceBetween,
                    y = -u,
                    b = 0,
                    _ = 0;
                if (void 0 !== n) {
                    "string" == typeof w && 0 <= w.indexOf("%") && (w = (parseFloat(w.replace("%", "")) / 100) * n),
                        (e.virtualSize = -w),
                        s ? o.css({ marginLeft: "", marginTop: "" }) : o.css({ marginRight: "", marginBottom: "" }),
                    1 < t.slidesPerColumn &&
                    ((p = Math.floor(r / t.slidesPerColumn) === r / e.params.slidesPerColumn ? r : Math.ceil(r / t.slidesPerColumn) * t.slidesPerColumn),
                    "auto" !== t.slidesPerView && "row" === t.slidesPerColumnFill && (p = Math.max(p, t.slidesPerView * t.slidesPerColumn)));
                    for (var k, x = t.slidesPerColumn, C = p / x, S = C - (t.slidesPerColumn * C - r), T = 0; T < r; T += 1) {
                        f = 0;
                        var $,
                            E,
                            D,
                            M = o.eq(T);
                        1 < t.slidesPerColumn &&
                        ((D = E = $ = void 0),
                            "column" === t.slidesPerColumnFill
                                ? ((D = T - (E = Math.floor(T / x)) * x),
                                (S < E || (E === S && D === x - 1)) && x <= (D += 1) && ((D = 0), (E += 1)),
                                    ($ = E + (D * p) / x),
                                    M.css({ "-webkit-box-ordinal-group": $, "-moz-box-ordinal-group": $, "-ms-flex-order": $, "-webkit-order": $, order: $ }))
                                : (E = T - (D = Math.floor(T / C)) * C),
                            M.css("margin-" + (e.isHorizontal() ? "top" : "left"), 0 !== D && t.spaceBetween && t.spaceBetween + "px")
                                .attr("data-swiper-column", E)
                                .attr("data-swiper-row", D)),
                        "none" !== M.css("display") &&
                        ("auto" === t.slidesPerView
                            ? ((f = e.isHorizontal() ? M.outerWidth(!0) : M.outerHeight(!0)), t.roundLengths && (f = Math.floor(f)))
                            : ((f = (n - (t.slidesPerView - 1) * w) / t.slidesPerView), t.roundLengths && (f = Math.floor(f)), o[T] && (e.isHorizontal() ? (o[T].style.width = f + "px") : (o[T].style.height = f + "px"))),
                        o[T] && (o[T].swiperSlideSize = f),
                            c.push(f),
                            t.centeredSlides
                                ? ((y = y + f / 2 + b / 2 + w), 0 === b && 0 !== T && (y = y - n / 2 - w), 0 === T && (y = y - n / 2 - w), Math.abs(y) < 0.001 && (y = 0), _ % t.slidesPerGroup == 0 && l.push(y), d.push(y))
                                : (_ % t.slidesPerGroup == 0 && l.push(y), d.push(y), (y = y + f + w)),
                            (e.virtualSize += f + w),
                            (b = f),
                            (_ += 1));
                    }
                    if (
                        ((e.virtualSize = Math.max(e.virtualSize, n) + h),
                        s && a && ("slide" === t.effect || "coverflow" === t.effect) && i.css({ width: e.virtualSize + t.spaceBetween + "px" }),
                        (A.flexbox && !t.setWrapperSize) || (e.isHorizontal() ? i.css({ width: e.virtualSize + t.spaceBetween + "px" }) : i.css({ height: e.virtualSize + t.spaceBetween + "px" })),
                        1 < t.slidesPerColumn &&
                        ((e.virtualSize = (f + t.spaceBetween) * p),
                            (e.virtualSize = Math.ceil(e.virtualSize / t.slidesPerColumn) - t.spaceBetween),
                            e.isHorizontal() ? i.css({ width: e.virtualSize + t.spaceBetween + "px" }) : i.css({ height: e.virtualSize + t.spaceBetween + "px" }),
                            t.centeredSlides))
                    ) {
                        k = [];
                        for (var O = 0; O < l.length; O += 1) l[O] < e.virtualSize + l[0] && k.push(l[O]);
                        l = k;
                    }
                    if (!t.centeredSlides) {
                        k = [];
                        for (var I = 0; I < l.length; I += 1) l[I] <= e.virtualSize - n && k.push(l[I]);
                        (l = k), 1 < Math.floor(e.virtualSize - n) - Math.floor(l[l.length - 1]) && l.push(e.virtualSize - n);
                    }
                    0 === l.length && (l = [0]),
                    0 !== t.spaceBetween && (e.isHorizontal() ? (s ? o.css({ marginLeft: w + "px" }) : o.css({ marginRight: w + "px" })) : o.css({ marginBottom: w + "px" })),
                        P.extend(e, { slides: o, snapGrid: l, slidesGrid: d, slidesSizesGrid: c }),
                    r !== m && e.emit("slidesLengthChange"),
                    l.length !== v && (e.params.watchOverflow && e.checkOverflow(), e.emit("snapGridLengthChange")),
                    d.length !== g && e.emit("slidesGridLengthChange"),
                    (t.watchSlidesProgress || t.watchSlidesVisibility) && e.updateSlidesOffset();
                }
            },
            updateAutoHeight: function () {
                var e,
                    t,
                    i = this,
                    n = [],
                    s = 0;
                if ("auto" !== i.params.slidesPerView && 1 < i.params.slidesPerView)
                    for (e = 0; e < Math.ceil(i.params.slidesPerView); e += 1) {
                        var a = i.activeIndex + e;
                        if (a > i.slides.length) break;
                        n.push(i.slides.eq(a)[0]);
                    }
                else n.push(i.slides.eq(i.activeIndex)[0]);
                for (e = 0; e < n.length; e += 1) void 0 !== n[e] && (s = s < (t = n[e].offsetHeight) ? t : s);
                s && i.$wrapperEl.css("height", s + "px");
            },
            updateSlidesOffset: function () {
                for (var e = this.slides, t = 0; t < e.length; t += 1) e[t].swiperSlideOffset = this.isHorizontal() ? e[t].offsetLeft : e[t].offsetTop;
            },
            updateSlidesProgress: function (e) {
                void 0 === e && (e = this.translate || 0);
                var t = this,
                    i = t.params,
                    n = t.slides,
                    s = t.rtl;
                if (0 !== n.length) {
                    void 0 === n[0].swiperSlideOffset && t.updateSlidesOffset();
                    var a = s ? e : -e;
                    n.removeClass(i.slideVisibleClass);
                    for (var o = 0; o < n.length; o += 1) {
                        var r,
                            l,
                            d = n[o],
                            c = (a + (i.centeredSlides ? t.minTranslate() : 0) - d.swiperSlideOffset) / (d.swiperSlideSize + i.spaceBetween);
                        i.watchSlidesVisibility && ((l = (r = -(a - d.swiperSlideOffset)) + t.slidesSizesGrid[o]), ((0 <= r && r < t.size) || (0 < l && l <= t.size) || (r <= 0 && l >= t.size)) && n.eq(o).addClass(i.slideVisibleClass)),
                            (d.progress = s ? -c : c);
                    }
                }
            },
            updateProgress: function (e) {
                void 0 === e && (e = this.translate || 0);
                var t = this,
                    i = t.params,
                    n = t.maxTranslate() - t.minTranslate(),
                    s = t.progress,
                    a = t.isBeginning,
                    o = a,
                    r = (l = t.isEnd),
                    l = 0 == n ? (a = !(s = 0)) : ((a = (s = (e - t.minTranslate()) / n) <= 0), 1 <= s);
                P.extend(t, { progress: s, isBeginning: a, isEnd: l }),
                (i.watchSlidesProgress || i.watchSlidesVisibility) && t.updateSlidesProgress(e),
                a && !o && t.emit("reachBeginning toEdge"),
                l && !r && t.emit("reachEnd toEdge"),
                ((o && !a) || (r && !l)) && t.emit("fromEdge"),
                    t.emit("progress", s);
            },
            updateSlidesClasses: function () {
                var e = this,
                    t = e.slides,
                    i = e.params,
                    n = e.$wrapperEl,
                    s = e.activeIndex,
                    a = e.realIndex,
                    o = e.virtual && i.virtual.enabled;
                t.removeClass(i.slideActiveClass + " " + i.slideNextClass + " " + i.slidePrevClass + " " + i.slideDuplicateActiveClass + " " + i.slideDuplicateNextClass + " " + i.slideDuplicatePrevClass),
                    (s = o ? e.$wrapperEl.find("." + i.slideClass + '[data-swiper-slide-index="' + s + '"]') : t.eq(s)).addClass(i.slideActiveClass),
                i.loop &&
                (s.hasClass(i.slideDuplicateClass)
                        ? n.children("." + i.slideClass + ":not(." + i.slideDuplicateClass + ')[data-swiper-slide-index="' + a + '"]')
                        : n.children("." + i.slideClass + "." + i.slideDuplicateClass + '[data-swiper-slide-index="' + a + '"]')
                ).addClass(i.slideDuplicateActiveClass);
                a = s
                    .nextAll("." + i.slideClass)
                    .eq(0)
                    .addClass(i.slideNextClass);
                i.loop && 0 === a.length && (a = t.eq(0)).addClass(i.slideNextClass);
                s = s
                    .prevAll("." + i.slideClass)
                    .eq(0)
                    .addClass(i.slidePrevClass);
                i.loop && 0 === s.length && (s = t.eq(-1)).addClass(i.slidePrevClass),
                i.loop &&
                ((a.hasClass(i.slideDuplicateClass)
                        ? n.children("." + i.slideClass + ":not(." + i.slideDuplicateClass + ')[data-swiper-slide-index="' + a.attr("data-swiper-slide-index") + '"]')
                        : n.children("." + i.slideClass + "." + i.slideDuplicateClass + '[data-swiper-slide-index="' + a.attr("data-swiper-slide-index") + '"]')
                ).addClass(i.slideDuplicateNextClass),
                    (s.hasClass(i.slideDuplicateClass)
                            ? n.children("." + i.slideClass + ":not(." + i.slideDuplicateClass + ')[data-swiper-slide-index="' + s.attr("data-swiper-slide-index") + '"]')
                            : n.children("." + i.slideClass + "." + i.slideDuplicateClass + '[data-swiper-slide-index="' + s.attr("data-swiper-slide-index") + '"]')
                    ).addClass(i.slideDuplicatePrevClass));
            },
            updateActiveIndex: function (e) {
                var t = this,
                    i = t.rtl ? t.translate : -t.translate,
                    n = t.slidesGrid,
                    s = t.snapGrid,
                    a = t.params,
                    o = t.activeIndex,
                    r = t.realIndex,
                    l = t.snapIndex,
                    d = e;
                if (void 0 === d) {
                    for (var c = 0; c < n.length; c += 1) void 0 !== n[c + 1] ? (i >= n[c] && i < n[c + 1] - (n[c + 1] - n[c]) / 2 ? (d = c) : i >= n[c] && i < n[c + 1] && (d = c + 1)) : i >= n[c] && (d = c);
                    a.normalizeSlideIndex && (d < 0 || void 0 === d) && (d = 0);
                }
                (a = 0 <= s.indexOf(i) ? s.indexOf(i) : Math.floor(d / a.slidesPerGroup)) >= s.length && (a = s.length - 1),
                    d !== o
                        ? ((s = parseInt(t.slides.eq(d).attr("data-swiper-slide-index") || d, 10)),
                            P.extend(t, { snapIndex: a, realIndex: s, previousIndex: o, activeIndex: d }),
                            t.emit("activeIndexChange"),
                            t.emit("snapIndexChange"),
                        r !== s && t.emit("realIndexChange"),
                            t.emit("slideChange"))
                        : a !== l && ((t.snapIndex = a), t.emit("snapIndexChange"));
            },
            updateClickedSlide: function (e) {
                var t = this,
                    i = t.params,
                    n = x(e.target).closest("." + i.slideClass)[0],
                    s = !1;
                if (n) for (var a = 0; a < t.slides.length; a += 1) t.slides[a] === n && (s = !0);
                if (!n || !s) return (t.clickedSlide = void 0), void (t.clickedIndex = void 0);
                (t.clickedSlide = n),
                    t.virtual && t.params.virtual.enabled ? (t.clickedIndex = parseInt(x(n).attr("data-swiper-slide-index"), 10)) : (t.clickedIndex = x(n).index()),
                i.slideToClickedSlide && void 0 !== t.clickedIndex && t.clickedIndex !== t.activeIndex && t.slideToClickedSlide();
            },
        },
        f = {
            getTranslate: function (e) {
                void 0 === e && (e = this.isHorizontal() ? "x" : "y");
                var t = this.params,
                    i = this.rtl,
                    n = this.translate,
                    s = this.$wrapperEl;
                if (t.virtualTranslate) return i ? -n : n;
                e = P.getTranslate(s[0], e);
                return i && (e = -e), e || 0;
            },
            setTranslate: function (e, t) {
                var i = this,
                    n = i.rtl,
                    s = i.params,
                    a = i.$wrapperEl,
                    o = i.progress,
                    r = 0,
                    l = 0;
                i.isHorizontal() ? (r = n ? -e : e) : (l = e),
                s.roundLengths && ((r = Math.floor(r)), (l = Math.floor(l))),
                s.virtualTranslate || (A.transforms3d ? a.transform("translate3d(" + r + "px, " + l + "px, 0px)") : a.transform("translate(" + r + "px, " + l + "px)")),
                    (i.translate = i.isHorizontal() ? r : l);
                l = i.maxTranslate() - i.minTranslate();
                (0 == l ? 0 : (e - i.minTranslate()) / l) !== o && i.updateProgress(e), i.emit("setTranslate", i.translate, t);
            },
            minTranslate: function () {
                return -this.snapGrid[0];
            },
            maxTranslate: function () {
                return -this.snapGrid[this.snapGrid.length - 1];
            },
        },
        m = {
            setTransition: function (e, t) {
                this.$wrapperEl.transition(e), this.emit("setTransition", e, t);
            },
            transitionStart: function (e, t) {
                void 0 === e && (e = !0);
                var i = this,
                    n = i.activeIndex,
                    s = i.params,
                    a = i.previousIndex;
                s.autoHeight && i.updateAutoHeight();
                t = t || (a < n ? "next" : n < a ? "prev" : "reset");
                i.emit("transitionStart"),
                e && n !== a && ("reset" !== t ? (i.emit("slideChangeTransitionStart"), "next" === t ? i.emit("slideNextTransitionStart") : i.emit("slidePrevTransitionStart")) : i.emit("slideResetTransitionStart"));
            },
            transitionEnd: function (e, t) {
                void 0 === e && (e = !0);
                var i = this,
                    n = i.activeIndex,
                    s = i.previousIndex;
                (i.animating = !1), i.setTransition(0);
                t = t || (s < n ? "next" : n < s ? "prev" : "reset");
                i.emit("transitionEnd"), e && n !== s && ("reset" !== t ? (i.emit("slideChangeTransitionEnd"), "next" === t ? i.emit("slideNextTransitionEnd") : i.emit("slidePrevTransitionEnd")) : i.emit("slideResetTransitionEnd"));
            },
        },
        v = {
            slideTo: function (e, t, i, n) {
                void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === i && (i = !0);
                var s = this,
                    a = e;
                a < 0 && (a = 0);
                var o = s.params,
                    r = s.snapGrid,
                    l = s.slidesGrid,
                    d = s.previousIndex,
                    c = s.activeIndex,
                    u = s.rtl,
                    h = s.$wrapperEl;
                if (s.animating && o.preventIntercationOnTransition) return !1;
                e = Math.floor(a / o.slidesPerGroup);
                e >= r.length && (e = r.length - 1), (c || o.initialSlide || 0) === (d || 0) && i && s.emit("beforeSlideChangeStart");
                var p,
                    f = -r[e];
                if ((s.updateProgress(f), o.normalizeSlideIndex)) for (var m = 0; m < l.length; m += 1) -Math.floor(100 * f) >= Math.floor(100 * l[m]) && (a = m);
                if (s.initialized && a !== c) {
                    if (!s.allowSlideNext && f < s.translate && f < s.minTranslate()) return !1;
                    if (!s.allowSlidePrev && f > s.translate && f > s.maxTranslate() && (c || 0) !== a) return !1;
                }
                return (
                    (p = c < a ? "next" : a < c ? "prev" : "reset"),
                        (u && -f === s.translate) || (!u && f === s.translate)
                            ? (s.updateActiveIndex(a), o.autoHeight && s.updateAutoHeight(), s.updateSlidesClasses(), "slide" !== o.effect && s.setTranslate(f), "reset" !== p && (s.transitionStart(i, p), s.transitionEnd(i, p)), !1)
                            : (0 !== t && A.transition
                                ? (s.setTransition(t),
                                    s.setTranslate(f),
                                    s.updateActiveIndex(a),
                                    s.updateSlidesClasses(),
                                    s.emit("beforeTransitionStart", t, n),
                                    s.transitionStart(i, p),
                                s.animating ||
                                ((s.animating = !0),
                                    h.transitionEnd(function () {
                                        s && !s.destroyed && s.transitionEnd(i, p);
                                    })))
                                : (s.setTransition(0), s.setTranslate(f), s.updateActiveIndex(a), s.updateSlidesClasses(), s.emit("beforeTransitionStart", t, n), s.transitionStart(i, p), s.transitionEnd(i, p)),
                                !0)
                );
            },
            slideToLoop: function (e, t, i, n) {
                void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === i && (i = !0);
                return this.params.loop && (e += this.loopedSlides), this.slideTo(e, t, i, n);
            },
            slideNext: function (e, t, i) {
                void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
                var n = this,
                    s = n.params,
                    a = n.animating;
                return s.loop ? !a && (n.loopFix(), (n._clientLeft = n.$wrapperEl[0].clientLeft), n.slideTo(n.activeIndex + s.slidesPerGroup, e, t, i)) : n.slideTo(n.activeIndex + s.slidesPerGroup, e, t, i);
            },
            slidePrev: function (e, t, i) {
                void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
                var n = this,
                    s = n.params,
                    a = n.animating;
                return s.loop ? !a && (n.loopFix(), (n._clientLeft = n.$wrapperEl[0].clientLeft), n.slideTo(n.activeIndex - 1, e, t, i)) : n.slideTo(n.activeIndex - 1, e, t, i);
            },
            slideReset: function (e, t, i) {
                void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
                return this.slideTo(this.activeIndex, e, t, i);
            },
            slideToClickedSlide: function () {
                var e,
                    t = this,
                    i = t.params,
                    n = t.$wrapperEl,
                    s = "auto" === i.slidesPerView ? t.slidesPerViewDynamic() : i.slidesPerView,
                    a = t.clickedIndex;
                i.loop
                    ? t.animating ||
                    ((e = parseInt(x(t.clickedSlide).attr("data-swiper-slide-index"), 10)),
                        i.centeredSlides
                            ? a < t.loopedSlides - s / 2 || a > t.slides.length - t.loopedSlides + s / 2
                                ? (t.loopFix(),
                                    (a = n
                                        .children("." + i.slideClass + '[data-swiper-slide-index="' + e + '"]:not(.' + i.slideDuplicateClass + ")")
                                        .eq(0)
                                        .index()),
                                    P.nextTick(function () {
                                        t.slideTo(a);
                                    }))
                                : t.slideTo(a)
                            : a > t.slides.length - s
                                ? (t.loopFix(),
                                    (a = n
                                        .children("." + i.slideClass + '[data-swiper-slide-index="' + e + '"]:not(.' + i.slideDuplicateClass + ")")
                                        .eq(0)
                                        .index()),
                                    P.nextTick(function () {
                                        t.slideTo(a);
                                    }))
                                : t.slideTo(a))
                    : t.slideTo(a);
            },
        },
        g = {
            loopCreate: function () {
                var n = this,
                    e = n.params,
                    t = n.$wrapperEl;
                t.children("." + e.slideClass + "." + e.slideDuplicateClass).remove();
                var s = t.children("." + e.slideClass);
                if (e.loopFillGroupWithBlank) {
                    var i = e.slidesPerGroup - (s.length % e.slidesPerGroup);
                    if (i !== e.slidesPerGroup) {
                        for (var a = 0; a < i; a += 1) {
                            var o = x(u.createElement("div")).addClass(e.slideClass + " " + e.slideBlankClass);
                            t.append(o);
                        }
                        s = t.children("." + e.slideClass);
                    }
                }
                "auto" !== e.slidesPerView || e.loopedSlides || (e.loopedSlides = s.length),
                    (n.loopedSlides = parseInt(e.loopedSlides || e.slidesPerView, 10)),
                    (n.loopedSlides += e.loopAdditionalSlides),
                n.loopedSlides > s.length && (n.loopedSlides = s.length);
                var r = [],
                    l = [];
                s.each(function (e, t) {
                    var i = x(t);
                    e < n.loopedSlides && l.push(t), e < s.length && e >= s.length - n.loopedSlides && r.push(t), i.attr("data-swiper-slide-index", e);
                });
                for (var d = 0; d < l.length; d += 1) t.append(x(l[d].cloneNode(!0)).addClass(e.slideDuplicateClass));
                for (var c = r.length - 1; 0 <= c; --c) t.prepend(x(r[c].cloneNode(!0)).addClass(e.slideDuplicateClass));
            },
            loopFix: function () {
                var e = this,
                    t = e.params,
                    i = e.activeIndex,
                    n = e.slides,
                    s = e.loopedSlides,
                    a = e.allowSlidePrev,
                    o = e.allowSlideNext,
                    r = e.snapGrid,
                    l = e.rtl;
                (e.allowSlidePrev = !0), (e.allowSlideNext = !0);
                var d,
                    r = -r[i] - e.getTranslate();
                i < s
                    ? ((d = n.length - 3 * s + i), (d += s), e.slideTo(d, 0, !1, !0) && 0 != r && e.setTranslate((l ? -e.translate : e.translate) - r))
                    : (("auto" === t.slidesPerView && 2 * s <= i) || i > n.length - 2 * t.slidesPerView) && ((d = -n.length + i + s), (d += s), e.slideTo(d, 0, !1, !0) && 0 != r && e.setTranslate((l ? -e.translate : e.translate) - r)),
                    (e.allowSlidePrev = a),
                    (e.allowSlideNext = o);
            },
            loopDestroy: function () {
                var e = this.$wrapperEl,
                    t = this.params,
                    i = this.slides;
                e.children("." + t.slideClass + "." + t.slideDuplicateClass).remove(), i.removeAttr("data-swiper-slide-index");
            },
        },
        w = {
            setGrabCursor: function (e) {
                var t;
                !A.touch &&
                this.params.simulateTouch &&
                (((t = this.el).style.cursor = "move"), (t.style.cursor = e ? "-webkit-grabbing" : "-webkit-grab"), (t.style.cursor = e ? "-moz-grabbin" : "-moz-grab"), (t.style.cursor = e ? "grabbing" : "grab"));
            },
            unsetGrabCursor: function () {
                A.touch || (this.el.style.cursor = "");
            },
        },
        y = {
            appendSlide: function (e) {
                var t = this,
                    i = t.$wrapperEl,
                    n = t.params;
                if ((n.loop && t.loopDestroy(), "object" == typeof e && "length" in e)) for (var s = 0; s < e.length; s += 1) e[s] && i.append(e[s]);
                else i.append(e);
                n.loop && t.loopCreate(), (n.observer && A.observer) || t.update();
            },
            prependSlide: function (e) {
                var t = this,
                    i = t.params,
                    n = t.$wrapperEl,
                    s = t.activeIndex;
                i.loop && t.loopDestroy();
                var a = s + 1;
                if ("object" == typeof e && "length" in e) {
                    for (var o = 0; o < e.length; o += 1) e[o] && n.prepend(e[o]);
                    a = s + e.length;
                } else n.prepend(e);
                i.loop && t.loopCreate(), (i.observer && A.observer) || t.update(), t.slideTo(a, 0, !1);
            },
            removeSlide: function (e) {
                var t = this,
                    i = t.params,
                    n = t.$wrapperEl,
                    s = t.activeIndex;
                i.loop && (t.loopDestroy(), (t.slides = n.children("." + i.slideClass)));
                var a,
                    o = s;
                if ("object" == typeof e && "length" in e) {
                    for (var r = 0; r < e.length; r += 1) (a = e[r]), t.slides[a] && t.slides.eq(a).remove(), a < o && --o;
                    o = Math.max(o, 0);
                } else (a = e), t.slides[a] && t.slides.eq(a).remove(), a < o && --o, (o = Math.max(o, 0));
                i.loop && t.loopCreate(), (i.observer && A.observer) || t.update(), i.loop ? t.slideTo(o + t.loopedSlides, 0, !1) : t.slideTo(o, 0, !1);
            },
            removeAllSlides: function () {
                for (var e = [], t = 0; t < this.slides.length; t += 1) e.push(t);
                this.removeSlide(e);
            },
        },
        b =
            ((k = c.navigator.userAgent),
                (_ = { ios: !1, android: !1, androidChrome: !1, desktop: !1, windows: !1, iphone: !1, ipod: !1, ipad: !1, cordova: c.cordova || c.phonegap, phonegap: c.cordova || c.phonegap }),
                (d = k.match(/(Windows Phone);?[\s\/]+([\d.]+)?/)),
                (e = k.match(/(Android);?[\s\/]+([\d.]+)?/)),
                (t = k.match(/(iPad).*OS\s([\d_]+)/)),
                (h = k.match(/(iPod)(.*OS\s([\d_]+))?/)),
                (o = !t && k.match(/(iPhone\sOS|iOS)\s([\d_]+)/)),
            d && ((_.os = "windows"), (_.osVersion = d[2]), (_.windows = !0)),
            e && !d && ((_.os = "android"), (_.osVersion = e[2]), (_.android = !0), (_.androidChrome = 0 <= k.toLowerCase().indexOf("chrome"))),
            (t || o || h) && ((_.os = "ios"), (_.ios = !0)),
            o && !h && ((_.osVersion = o[2].replace(/_/g, ".")), (_.iphone = !0)),
            t && ((_.osVersion = t[2].replace(/_/g, ".")), (_.ipad = !0)),
            h && ((_.osVersion = h[3] ? h[3].replace(/_/g, ".") : null), (_.iphone = !0)),
            _.ios && _.osVersion && 0 <= k.indexOf("Version/") && "10" === _.osVersion.split(".")[0] && (_.osVersion = k.toLowerCase().split("version/")[1].split(" ")[0]),
                (_.desktop = !(_.os || _.android || _.webView)),
                (_.webView = (o || t || h) && k.match(/.*AppleWebKit(?!.*Safari)/i)),
            _.os &&
            "ios" === _.os &&
            ((t = _.osVersion.split(".")), (k = u.querySelector('meta[name="viewport"]')), (_.minimalUi = !_.webView && (h || o) && (7 == +t[0] ? 1 <= +t[1] : 7 < +t[0]) && k && 0 <= k.getAttribute("content").indexOf("minimal-ui"))),
                (_.pixelRatio = c.devicePixelRatio || 1),
                _);
    var _,
        t = {
            attachEvents: function () {
                var e = this,
                    t = e.params,
                    i = e.touchEvents,
                    n = e.el,
                    s = e.wrapperEl;
                (e.onTouchStart = function (e) {
                    var t,
                        i,
                        n = this,
                        s = n.touchEventsData,
                        a = n.params,
                        o = n.touches;
                    (n.animating && a.preventIntercationOnTransition) ||
                    ((t = e).originalEvent && (t = t.originalEvent),
                        (s.isTouchEvent = "touchstart" === t.type),
                    (!s.isTouchEvent && "which" in t && 3 === t.which) ||
                    (s.isTouched && s.isMoved) ||
                    (a.noSwiping && x(t.target).closest(a.noSwipingSelector || "." + a.noSwipingClass)[0]
                        ? (n.allowClick = !0)
                        : (a.swipeHandler && !x(t).closest(a.swipeHandler)[0]) ||
                        ((o.currentX = ("touchstart" === t.type ? t.targetTouches[0] : t).pageX),
                            (o.currentY = ("touchstart" === t.type ? t.targetTouches[0] : t).pageY),
                            (i = o.currentX),
                            (e = o.currentY),
                        (b.ios && !b.cordova && a.iOSEdgeSwipeDetection && i <= a.iOSEdgeSwipeThreshold && i >= c.screen.width - a.iOSEdgeSwipeThreshold) ||
                        (P.extend(s, { isTouched: !0, isMoved: !1, allowTouchCallbacks: !0, isScrolling: void 0, startMoving: void 0 }),
                            (o.startX = i),
                            (o.startY = e),
                            (s.touchStartTime = P.now()),
                            (n.allowClick = !0),
                            n.updateSize(),
                            (n.swipeDirection = void 0),
                        0 < a.threshold && (s.allowThresholdMove = !1),
                        "touchstart" !== t.type &&
                        ((a = !0),
                        x(t.target).is(s.formElements) && (a = !1),
                        u.activeElement && x(u.activeElement).is(s.formElements) && u.activeElement !== t.target && u.activeElement.blur(),
                        a && n.allowTouchMove && t.preventDefault()),
                            n.emit("touchStart", t)))));
                }.bind(e)),
                    (e.onTouchMove = function (e) {
                        var t = this,
                            i = t.touchEventsData,
                            n = t.params,
                            s = t.touches,
                            a = t.rtl,
                            o = e;
                        if ((o.originalEvent && (o = o.originalEvent), i.isTouched)) {
                            if (!i.isTouchEvent || "mousemove" !== o.type) {
                                var r = ("touchmove" === o.type ? o.targetTouches[0] : o).pageX,
                                    l = ("touchmove" === o.type ? o.targetTouches[0] : o).pageY;
                                if (o.preventedByNestedSwiper) return (s.startX = r), void (s.startY = l);
                                if (!t.allowTouchMove) return (t.allowClick = !1), void (i.isTouched && (P.extend(s, { startX: r, startY: l, currentX: r, currentY: l }), (i.touchStartTime = P.now())));
                                if (i.isTouchEvent && n.touchReleaseOnEdges && !n.loop)
                                    if (t.isVertical()) {
                                        if ((l < s.startY && t.translate <= t.maxTranslate()) || (l > s.startY && t.translate >= t.minTranslate())) return (i.isTouched = !1), void (i.isMoved = !1);
                                    } else if ((r < s.startX && t.translate <= t.maxTranslate()) || (r > s.startX && t.translate >= t.minTranslate())) return;
                                if (i.isTouchEvent && u.activeElement && o.target === u.activeElement && x(o.target).is(i.formElements)) return (i.isMoved = !0), void (t.allowClick = !1);
                                if ((i.allowTouchCallbacks && t.emit("touchMove", o), !(o.targetTouches && 1 < o.targetTouches.length))) {
                                    (s.currentX = r), (s.currentY = l);
                                    (e = s.currentX - s.startX), (r = s.currentY - s.startY);
                                    if (
                                        (void 0 === i.isScrolling &&
                                        ((t.isHorizontal() && s.currentY === s.startY) || (t.isVertical() && s.currentX === s.startX)
                                            ? (i.isScrolling = !1)
                                            : 25 <= e * e + r * r && ((l = (180 * Math.atan2(Math.abs(r), Math.abs(e))) / Math.PI), (i.isScrolling = t.isHorizontal() ? l > n.touchAngle : 90 - l > n.touchAngle))),
                                        i.isScrolling && t.emit("touchMoveOpposite", o),
                                        "undefined" == typeof startMoving && ((s.currentX === s.startX && s.currentY === s.startY) || (i.startMoving = !0)),
                                            i.isScrolling)
                                    )
                                        i.isTouched = !1;
                                    else if (i.startMoving) {
                                        (t.allowClick = !1),
                                            o.preventDefault(),
                                        n.touchMoveStopPropagation && !n.nested && o.stopPropagation(),
                                        i.isMoved ||
                                        (n.loop && t.loopFix(),
                                            (i.startTranslate = t.getTranslate()),
                                            t.setTransition(0),
                                        t.animating && t.$wrapperEl.trigger("webkitTransitionEnd transitionend"),
                                            (i.allowMomentumBounce = !1),
                                        !n.grabCursor || (!0 !== t.allowSlideNext && !0 !== t.allowSlidePrev) || t.setGrabCursor(!0),
                                            t.emit("sliderFirstMove", o)),
                                            t.emit("sliderMove", o),
                                            (i.isMoved = !0);
                                        e = t.isHorizontal() ? e : r;
                                        (s.diff = e), (e *= n.touchRatio), a && (e = -e), (t.swipeDirection = 0 < e ? "prev" : "next"), (i.currentTranslate = e + i.startTranslate);
                                        (r = !0), (a = n.resistanceRatio);
                                        if (
                                            (n.touchReleaseOnEdges && (a = 0),
                                                0 < e && i.currentTranslate > t.minTranslate()
                                                    ? ((r = !1), n.resistance && (i.currentTranslate = t.minTranslate() - 1 + Math.pow(-t.minTranslate() + i.startTranslate + e, a)))
                                                    : e < 0 && i.currentTranslate < t.maxTranslate() && ((r = !1), n.resistance && (i.currentTranslate = t.maxTranslate() + 1 - Math.pow(t.maxTranslate() - i.startTranslate - e, a))),
                                            r && (o.preventedByNestedSwiper = !0),
                                            !t.allowSlideNext && "next" === t.swipeDirection && i.currentTranslate < i.startTranslate && (i.currentTranslate = i.startTranslate),
                                            !t.allowSlidePrev && "prev" === t.swipeDirection && i.currentTranslate > i.startTranslate && (i.currentTranslate = i.startTranslate),
                                            0 < n.threshold)
                                        ) {
                                            if (!(Math.abs(e) > n.threshold || i.allowThresholdMove)) return void (i.currentTranslate = i.startTranslate);
                                            if (!i.allowThresholdMove)
                                                return (
                                                    (i.allowThresholdMove = !0),
                                                        (s.startX = s.currentX),
                                                        (s.startY = s.currentY),
                                                        (i.currentTranslate = i.startTranslate),
                                                        void (s.diff = t.isHorizontal() ? s.currentX - s.startX : s.currentY - s.startY)
                                                );
                                        }
                                        n.followFinger &&
                                        ((n.freeMode || n.watchSlidesProgress || n.watchSlidesVisibility) && (t.updateActiveIndex(), t.updateSlidesClasses()),
                                        n.freeMode &&
                                        (0 === i.velocities.length && i.velocities.push({ position: s[t.isHorizontal() ? "startX" : "startY"], time: i.touchStartTime }),
                                            i.velocities.push({ position: s[t.isHorizontal() ? "currentX" : "currentY"], time: P.now() })),
                                            t.updateProgress(i.currentTranslate),
                                            t.setTranslate(i.currentTranslate));
                                    }
                                }
                            }
                        } else i.startMoving && i.isScrolling && t.emit("touchMoveOpposite", o);
                    }.bind(e)),
                    (e.onTouchEnd = function (e) {
                        var t = this,
                            i = t.touchEventsData,
                            n = t.params,
                            s = t.touches,
                            a = t.rtl,
                            o = t.$wrapperEl,
                            r = t.slidesGrid,
                            l = t.snapGrid,
                            d = e;
                        if ((d.originalEvent && (d = d.originalEvent), i.allowTouchCallbacks && t.emit("touchEnd", d), (i.allowTouchCallbacks = !1), !i.isTouched))
                            return i.isMoved && n.grabCursor && t.setGrabCursor(!1), (i.isMoved = !1), void (i.startMoving = !1);
                        n.grabCursor && i.isMoved && i.isTouched && (!0 === t.allowSlideNext || !0 === t.allowSlidePrev) && t.setGrabCursor(!1);
                        var c,
                            u = P.now(),
                            e = u - i.touchStartTime;
                        if (
                            (t.allowClick &&
                            (t.updateClickedSlide(d),
                                t.emit("tap", d),
                            e < 300 &&
                            300 < u - i.lastClickTime &&
                            (i.clickTimeout && clearTimeout(i.clickTimeout),
                                (i.clickTimeout = P.nextTick(function () {
                                    t && !t.destroyed && t.emit("click", d);
                                }, 300))),
                            e < 300 && u - i.lastClickTime < 300 && (i.clickTimeout && clearTimeout(i.clickTimeout), t.emit("doubleTap", d))),
                                (i.lastClickTime = P.now()),
                                P.nextTick(function () {
                                    t.destroyed || (t.allowClick = !0);
                                }),
                            !i.isTouched || !i.isMoved || !t.swipeDirection || 0 === s.diff || i.currentTranslate === i.startTranslate)
                        )
                            return (i.isTouched = !1), (i.isMoved = !1), void (i.startMoving = !1);
                        if (((i.isTouched = !1), (i.isMoved = !1), (i.startMoving = !1), (c = n.followFinger ? (a ? t.translate : -t.translate) : -i.currentTranslate), n.freeMode))
                            if (c < -t.minTranslate()) t.slideTo(t.activeIndex);
                            else if (c > -t.maxTranslate()) t.slides.length < l.length ? t.slideTo(l.length - 1) : t.slideTo(t.slides.length - 1);
                            else {
                                if (n.freeModeMomentum) {
                                    1 < i.velocities.length
                                        ? ((v = i.velocities.pop()),
                                            (p = i.velocities.pop()),
                                            (h = v.position - p.position),
                                            (p = v.time - p.time),
                                            (t.velocity = h / p),
                                            (t.velocity /= 2),
                                        Math.abs(t.velocity) < n.freeModeMinimumVelocity && (t.velocity = 0),
                                        (150 < p || 300 < P.now() - v.time) && (t.velocity = 0))
                                        : (t.velocity = 0),
                                        (t.velocity *= n.freeModeMomentumVelocityRatio),
                                        (i.velocities.length = 0);
                                    var h = 1e3 * n.freeModeMomentumRatio,
                                        p = t.velocity * h,
                                        f = t.translate + p;
                                    a && (f = -f);
                                    var m,
                                        v = !1,
                                        p = 20 * Math.abs(t.velocity) * n.freeModeMomentumBounceRatio;
                                    if (f < t.maxTranslate()) n.freeModeMomentumBounce ? (f + t.maxTranslate() < -p && (f = t.maxTranslate() - p), (m = t.maxTranslate()), (v = !0), (i.allowMomentumBounce = !0)) : (f = t.maxTranslate());
                                    else if (f > t.minTranslate()) n.freeModeMomentumBounce ? (f - t.minTranslate() > p && (f = t.minTranslate() + p), (m = t.minTranslate()), (v = !0), (i.allowMomentumBounce = !0)) : (f = t.minTranslate());
                                    else if (n.freeModeSticky) {
                                        for (var g, w = 0; w < l.length; w += 1)
                                            if (l[w] > -f) {
                                                g = w;
                                                break;
                                            }
                                        f = -(f = Math.abs(l[g] - f) < Math.abs(l[g - 1] - f) || "next" === t.swipeDirection ? l[g] : l[g - 1]);
                                    }
                                    if (0 !== t.velocity) h = a ? Math.abs((-f - t.translate) / t.velocity) : Math.abs((f - t.translate) / t.velocity);
                                    else if (n.freeModeSticky) return void t.slideReset();
                                    n.freeModeMomentumBounce && v
                                        ? (t.updateProgress(m),
                                            t.setTransition(h),
                                            t.setTranslate(f),
                                            t.transitionStart(!0, t.swipeDirection),
                                            (t.animating = !0),
                                            o.transitionEnd(function () {
                                                t &&
                                                !t.destroyed &&
                                                i.allowMomentumBounce &&
                                                (t.emit("momentumBounce"),
                                                    t.setTransition(n.speed),
                                                    t.setTranslate(m),
                                                    o.transitionEnd(function () {
                                                        t && !t.destroyed && t.transitionEnd();
                                                    }));
                                            }))
                                        : t.velocity
                                            ? (t.updateProgress(f),
                                                t.setTransition(h),
                                                t.setTranslate(f),
                                                t.transitionStart(!0, t.swipeDirection),
                                            t.animating ||
                                            ((t.animating = !0),
                                                o.transitionEnd(function () {
                                                    t && !t.destroyed && t.transitionEnd();
                                                })))
                                            : t.updateProgress(f),
                                        t.updateActiveIndex(),
                                        t.updateSlidesClasses();
                                }
                                (!n.freeModeMomentum || e >= n.longSwipesMs) && (t.updateProgress(), t.updateActiveIndex(), t.updateSlidesClasses());
                            }
                        else {
                            for (var y = 0, b = t.slidesSizesGrid[0], _ = 0; _ < r.length; _ += n.slidesPerGroup)
                                void 0 !== r[_ + n.slidesPerGroup] ? c >= r[_] && c < r[_ + n.slidesPerGroup] && (b = r[(y = _) + n.slidesPerGroup] - r[_]) : c >= r[_] && ((y = _), (b = r[r.length - 1] - r[r.length - 2]));
                            h = (c - r[y]) / b;
                            e > n.longSwipesMs
                                ? n.longSwipes
                                    ? ("next" === t.swipeDirection && (h >= n.longSwipesRatio ? t.slideTo(y + n.slidesPerGroup) : t.slideTo(y)),
                                    "prev" === t.swipeDirection && (h > 1 - n.longSwipesRatio ? t.slideTo(y + n.slidesPerGroup) : t.slideTo(y)))
                                    : t.slideTo(t.activeIndex)
                                : n.shortSwipes
                                    ? ("next" === t.swipeDirection && t.slideTo(y + n.slidesPerGroup), "prev" === t.swipeDirection && t.slideTo(y))
                                    : t.slideTo(t.activeIndex);
                        }
                    }.bind(e)),
                    (e.onClick = function (e) {
                        this.allowClick || (this.params.preventClicks && e.preventDefault(), this.params.preventClicksPropagation && this.animating && (e.stopPropagation(), e.stopImmediatePropagation()));
                    }.bind(e));
                var a = "container" === t.touchEventsTarget ? n : s,
                    n = !!t.nested;
                A.touch || (!A.pointerEvents && !A.prefixedPointerEvents)
                    ? (A.touch &&
                    ((s = !("touchstart" !== i.start || !A.passiveListener || !t.passiveListeners) && { passive: !0, capture: !1 }),
                        a.addEventListener(i.start, e.onTouchStart, s),
                        a.addEventListener(i.move, e.onTouchMove, A.passiveListener ? { passive: !1, capture: n } : n),
                        a.addEventListener(i.end, e.onTouchEnd, s)),
                    ((t.simulateTouch && !b.ios && !b.android) || (t.simulateTouch && !A.touch && b.ios)) &&
                    (a.addEventListener("mousedown", e.onTouchStart, !1), u.addEventListener("mousemove", e.onTouchMove, n), u.addEventListener("mouseup", e.onTouchEnd, !1)))
                    : (a.addEventListener(i.start, e.onTouchStart, !1), u.addEventListener(i.move, e.onTouchMove, n), u.addEventListener(i.end, e.onTouchEnd, !1)),
                (t.preventClicks || t.preventClicksPropagation) && a.addEventListener("click", e.onClick, !0),
                    e.on("resize observerUpdate", r);
            },
            detachEvents: function () {
                var e = this,
                    t = e.params,
                    i = e.touchEvents,
                    n = e.el,
                    s = e.wrapperEl,
                    a = "container" === t.touchEventsTarget ? n : s,
                    n = !!t.nested;
                A.touch || (!A.pointerEvents && !A.prefixedPointerEvents)
                    ? (A.touch &&
                    ((s = !("onTouchStart" !== i.start || !A.passiveListener || !t.passiveListeners) && { passive: !0, capture: !1 }),
                        a.removeEventListener(i.start, e.onTouchStart, s),
                        a.removeEventListener(i.move, e.onTouchMove, n),
                        a.removeEventListener(i.end, e.onTouchEnd, s)),
                    ((t.simulateTouch && !b.ios && !b.android) || (t.simulateTouch && !A.touch && b.ios)) &&
                    (a.removeEventListener("mousedown", e.onTouchStart, !1), u.removeEventListener("mousemove", e.onTouchMove, n), u.removeEventListener("mouseup", e.onTouchEnd, !1)))
                    : (a.removeEventListener(i.start, e.onTouchStart, !1), u.removeEventListener(i.move, e.onTouchMove, n), u.removeEventListener(i.end, e.onTouchEnd, !1)),
                (t.preventClicks || t.preventClicksPropagation) && a.removeEventListener("click", e.onClick, !0),
                    e.off("resize observerUpdate", r);
            },
        },
        k = {
            setBreakpoint: function () {
                var e = this,
                    t = e.activeIndex,
                    i = e.loopedSlides;
                void 0 === i && (i = 0);
                var n,
                    s = e.params,
                    a = s.breakpoints;
                !a ||
                (a && 0 === Object.keys(a).length) ||
                ((n = e.getBreakpoint(a)) &&
                    e.currentBreakpoint !== n &&
                    ((a = n in a ? a[n] : e.originalParams),
                        (s = s.loop && a.slidesPerView !== s.slidesPerView),
                        P.extend(e.params, a),
                        P.extend(e, { allowTouchMove: e.params.allowTouchMove, allowSlideNext: e.params.allowSlideNext, allowSlidePrev: e.params.allowSlidePrev }),
                        (e.currentBreakpoint = n),
                    s && (e.loopDestroy(), e.loopCreate(), e.updateSlides(), e.slideTo(t - i + e.loopedSlides, 0, !1)),
                        e.emit("breakpoint", a)));
            },
            getBreakpoint: function (e) {
                if (e) {
                    var t = !1,
                        i = [];
                    Object.keys(e).forEach(function (e) {
                        i.push(e);
                    }),
                        i.sort(function (e, t) {
                            return parseInt(e, 10) - parseInt(t, 10);
                        });
                    for (var n = 0; n < i.length; n += 1) {
                        var s = i[n];
                        s >= c.innerWidth && !t && (t = s);
                    }
                    return t || "max";
                }
            },
        },
        C = {
            isIE: !!c.navigator.userAgent.match(/Trident/g) || !!c.navigator.userAgent.match(/MSIE/g),
            isSafari: 0 <= (_ = c.navigator.userAgent.toLowerCase()).indexOf("safari") && _.indexOf("chrome") < 0 && _.indexOf("android") < 0,
            isUiWebView: /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(c.navigator.userAgent),
        };
    var S = {
            init: !0,
            direction: "horizontal",
            touchEventsTarget: "container",
            initialSlide: 0,
            speed: 300,
            preventIntercationOnTransition: !1,
            iOSEdgeSwipeDetection: !1,
            iOSEdgeSwipeThreshold: 20,
            freeMode: !1,
            freeModeMomentum: !0,
            freeModeMomentumRatio: 1,
            freeModeMomentumBounce: !0,
            freeModeMomentumBounceRatio: 1,
            freeModeMomentumVelocityRatio: 1,
            freeModeSticky: !1,
            freeModeMinimumVelocity: 0.02,
            autoHeight: !1,
            setWrapperSize: !1,
            virtualTranslate: !1,
            effect: "slide",
            breakpoints: void 0,
            spaceBetween: 0,
            slidesPerView: 1,
            slidesPerColumn: 1,
            slidesPerColumnFill: "column",
            slidesPerGroup: 1,
            centeredSlides: !1,
            slidesOffsetBefore: 0,
            slidesOffsetAfter: 0,
            normalizeSlideIndex: !0,
            watchOverflow: !1,
            roundLengths: !1,
            touchRatio: 1,
            touchAngle: 45,
            simulateTouch: !0,
            shortSwipes: !0,
            longSwipes: !0,
            longSwipesRatio: 0.5,
            longSwipesMs: 300,
            followFinger: !0,
            allowTouchMove: !0,
            threshold: 0,
            touchMoveStopPropagation: !0,
            touchReleaseOnEdges: !1,
            uniqueNavElements: !0,
            resistance: !0,
            resistanceRatio: 0.85,
            watchSlidesProgress: !1,
            watchSlidesVisibility: !1,
            grabCursor: !1,
            preventClicks: !0,
            preventClicksPropagation: !0,
            slideToClickedSlide: !1,
            preloadImages: !0,
            updateOnImagesReady: !0,
            loop: !1,
            loopAdditionalSlides: 0,
            loopedSlides: null,
            loopFillGroupWithBlank: !1,
            allowSlidePrev: !0,
            allowSlideNext: !0,
            swipeHandler: null,
            noSwiping: !0,
            noSwipingClass: "swiper-no-swiping",
            noSwipingSelector: null,
            passiveListeners: !0,
            containerModifierClass: "swiper-container-",
            slideClass: "swiper-slide",
            slideBlankClass: "swiper-slide-invisible-blank",
            slideActiveClass: "swiper-slide-active",
            slideDuplicateActiveClass: "swiper-slide-duplicate-active",
            slideVisibleClass: "swiper-slide-visible",
            slideDuplicateClass: "swiper-slide-duplicate",
            slideNextClass: "swiper-slide-next",
            slideDuplicateNextClass: "swiper-slide-duplicate-next",
            slidePrevClass: "swiper-slide-prev",
            slideDuplicatePrevClass: "swiper-slide-duplicate-prev",
            wrapperClass: "swiper-wrapper",
            runCallbacksOnInit: !0,
        },
        T = {
            update: p,
            translate: f,
            transition: m,
            slide: v,
            loop: g,
            grabCursor: w,
            manipulation: y,
            events: t,
            breakpoints: k,
            checkOverflow: {
                checkOverflow: function () {
                    var e = this,
                        t = e.isLocked;
                    (e.isLocked = 1 === e.snapGrid.length), (e.allowTouchMove = !e.isLocked), t && t !== e.isLocked && ((e.isEnd = !1), e.navigation.update());
                },
            },
            classes: {
                addClasses: function () {
                    var t = this.classNames,
                        i = this.params,
                        e = this.rtl,
                        n = this.$el,
                        s = [];
                    s.push(i.direction),
                    i.freeMode && s.push("free-mode"),
                    A.flexbox || s.push("no-flexbox"),
                    i.autoHeight && s.push("autoheight"),
                    e && s.push("rtl"),
                    1 < i.slidesPerColumn && s.push("multirow"),
                    b.android && s.push("android"),
                    b.ios && s.push("ios"),
                    C.isIE && (A.pointerEvents || A.prefixedPointerEvents) && s.push("wp8-" + i.direction),
                        s.forEach(function (e) {
                            t.push(i.containerModifierClass + e);
                        }),
                        n.addClass(t.join(" "));
                },
                removeClasses: function () {
                    var e = this.$el,
                        t = this.classNames;
                    e.removeClass(t.join(" "));
                },
            },
            images: {
                loadImage: function (e, t, i, n, s, a) {
                    function o() {
                        a && a();
                    }
                    (!e.complete || !s) && t ? (((s = new c.Image()).onload = o), (s.onerror = o), n && (s.sizes = n), i && (s.srcset = i), t && (s.src = t)) : o();
                },
                preloadImages: function () {
                    var e = this;
                    function t() {
                        null != e && e && !e.destroyed && (void 0 !== e.imagesLoaded && (e.imagesLoaded += 1), e.imagesLoaded === e.imagesToLoad.length && (e.params.updateOnImagesReady && e.update(), e.emit("imagesReady")));
                    }
                    e.imagesToLoad = e.$el.find("img");
                    for (var i = 0; i < e.imagesToLoad.length; i += 1) {
                        var n = e.imagesToLoad[i];
                        e.loadImage(n, n.currentSrc || n.getAttribute("src"), n.srcset || n.getAttribute("srcset"), n.sizes || n.getAttribute("sizes"), !0, t);
                    }
                },
            },
        },
        $ = {},
        E = (function (l) {
            function d() {
                for (var e, i, t = [], n = arguments.length; n--; ) t[n] = arguments[n];
                (i = (i = 1 === t.length && t[0].constructor && t[0].constructor === Object ? t[0] : ((e = t[0]), t[1])) || {}),
                    (i = P.extend({}, i)),
                e && !i.el && (i.el = e),
                    l.call(this, i),
                    Object.keys(T).forEach(function (t) {
                        Object.keys(T[t]).forEach(function (e) {
                            d.prototype[e] || (d.prototype[e] = T[t][e]);
                        });
                    });
                var s = this;
                void 0 === s.modules && (s.modules = {}),
                    Object.keys(s.modules).forEach(function (e) {
                        var t = s.modules[e];
                        t.params &&
                        ((e = Object.keys(t.params)[0]),
                        "object" == typeof (t = t.params[e]) &&
                        e in i &&
                        "enabled" in t &&
                        (!0 === i[e] && (i[e] = { enabled: !0 }), "object" != typeof i[e] || "enabled" in i[e] || (i[e].enabled = !0), i[e] || (i[e] = { enabled: !1 })));
                    });
                var a = P.extend({}, S);
                s.useModulesParams(a), (s.params = P.extend({}, a, $, i)), (s.originalParams = P.extend({}, s.params)), (s.passedParams = P.extend({}, i));
                var o = (s.$ = x)(s.params.el);
                if ((e = o[0])) {
                    if (1 < o.length) {
                        var r = [];
                        return (
                            o.each(function (e, t) {
                                t = P.extend({}, i, { el: t });
                                r.push(new d(t));
                            }),
                                r
                        );
                    }
                    (e.swiper = s), o.data("swiper", s);
                    a = o.children("." + s.params.wrapperClass);
                    return (
                        P.extend(s, {
                            $el: o,
                            el: e,
                            $wrapperEl: a,
                            wrapperEl: a[0],
                            classNames: [],
                            slides: x(),
                            slidesGrid: [],
                            snapGrid: [],
                            slidesSizesGrid: [],
                            isHorizontal: function () {
                                return "horizontal" === s.params.direction;
                            },
                            isVertical: function () {
                                return "vertical" === s.params.direction;
                            },
                            rtl: "horizontal" === s.params.direction && ("rtl" === e.dir.toLowerCase() || "rtl" === o.css("direction")),
                            wrongRTL: "-webkit-box" === a.css("display"),
                            activeIndex: 0,
                            realIndex: 0,
                            isBeginning: !0,
                            isEnd: !1,
                            translate: 0,
                            progress: 0,
                            velocity: 0,
                            animating: !1,
                            allowSlideNext: s.params.allowSlideNext,
                            allowSlidePrev: s.params.allowSlidePrev,
                            touchEvents:
                                ((o = ["touchstart", "touchmove", "touchend"]),
                                    (a = ["mousedown", "mousemove", "mouseup"]),
                                    A.pointerEvents ? (a = ["pointerdown", "pointermove", "pointerup"]) : A.prefixedPointerEvents && (a = ["MSPointerDown", "MSPointerMove", "MSPointerUp"]),
                                    (s.touchEventsTouch = { start: o[0], move: o[1], end: o[2] }),
                                    (s.touchEventsDesktop = { start: a[0], move: a[1], end: a[2] }),
                                    A.touch || !s.params.simulateTouch ? s.touchEventsTouch : s.touchEventsDesktop),
                            touchEventsData: {
                                isTouched: void 0,
                                isMoved: void 0,
                                allowTouchCallbacks: void 0,
                                touchStartTime: void 0,
                                isScrolling: void 0,
                                currentTranslate: void 0,
                                startTranslate: void 0,
                                allowThresholdMove: void 0,
                                formElements: "input, select, option, textarea, button, video",
                                lastClickTime: P.now(),
                                clickTimeout: void 0,
                                velocities: [],
                                allowMomentumBounce: void 0,
                                isTouchEvent: void 0,
                                startMoving: void 0,
                            },
                            allowClick: !0,
                            allowTouchMove: s.params.allowTouchMove,
                            touches: { startX: 0, startY: 0, currentX: 0, currentY: 0, diff: 0 },
                            imagesToLoad: [],
                            imagesLoaded: 0,
                        }),
                            s.useModules(),
                        s.params.init && s.init(),
                            s
                    );
                }
            }
            l && (d.__proto__ = l), (d.prototype = Object.create(l && l.prototype));
            var e = { extendedDefaults: { configurable: !0 }, defaults: { configurable: !0 }, Class: { configurable: !0 }, $: { configurable: !0 } };
            return (
                ((d.prototype.constructor = d).prototype.slidesPerViewDynamic = function () {
                    var e = this,
                        t = e.params,
                        i = e.slides,
                        n = e.slidesGrid,
                        s = e.size,
                        a = e.activeIndex,
                        o = 1;
                    if (t.centeredSlides) {
                        for (var r, l = i[a].swiperSlideSize, d = a + 1; d < i.length; d += 1) i[d] && !r && ((o += 1), s < (l += i[d].swiperSlideSize) && (r = !0));
                        for (var c = a - 1; 0 <= c; --c) i[c] && !r && ((o += 1), s < (l += i[c].swiperSlideSize) && (r = !0));
                    } else for (var u = a + 1; u < i.length; u += 1) n[u] - n[a] < s && (o += 1);
                    return o;
                }),
                    (d.prototype.update = function () {
                        var t = this;
                        function e() {
                            var e = t.rtl ? -1 * t.translate : t.translate,
                                e = Math.min(Math.max(e, t.maxTranslate()), t.minTranslate());
                            t.setTranslate(e), t.updateActiveIndex(), t.updateSlidesClasses();
                        }
                        t &&
                        !t.destroyed &&
                        (t.updateSize(),
                            t.updateSlides(),
                            t.updateProgress(),
                            t.updateSlidesClasses(),
                            t.params.freeMode
                                ? (e(), t.params.autoHeight && t.updateAutoHeight())
                                : (("auto" === t.params.slidesPerView || 1 < t.params.slidesPerView) && t.isEnd && !t.params.centeredSlides ? t.slideTo(t.slides.length - 1, 0, !1, !0) : t.slideTo(t.activeIndex, 0, !1, !0)) || e(),
                            t.emit("update"));
                    }),
                    (d.prototype.init = function () {
                        var e = this;
                        e.initialized ||
                        (e.emit("beforeInit"),
                        e.params.breakpoints && e.setBreakpoint(),
                            e.addClasses(),
                        e.params.loop && e.loopCreate(),
                            e.updateSize(),
                            e.updateSlides(),
                        e.params.watchOverflow && e.checkOverflow(),
                        e.params.grabCursor && e.setGrabCursor(),
                        e.params.preloadImages && e.preloadImages(),
                            e.params.loop ? e.slideTo(e.params.initialSlide + e.loopedSlides, 0, e.params.runCallbacksOnInit) : e.slideTo(e.params.initialSlide, 0, e.params.runCallbacksOnInit),
                            e.attachEvents(),
                            (e.initialized = !0),
                            e.emit("init"));
                    }),
                    (d.prototype.destroy = function (e, t) {
                        void 0 === e && (e = !0), void 0 === t && (t = !0);
                        var i = this,
                            n = i.params,
                            s = i.$el,
                            a = i.$wrapperEl,
                            o = i.slides;
                        i.emit("beforeDestroy"),
                            (i.initialized = !1),
                            i.detachEvents(),
                        n.loop && i.loopDestroy(),
                        t &&
                        (i.removeClasses(),
                            s.removeAttr("style"),
                            a.removeAttr("style"),
                        o &&
                        o.length &&
                        o
                            .removeClass([n.slideVisibleClass, n.slideActiveClass, n.slideNextClass, n.slidePrevClass].join(" "))
                            .removeAttr("style")
                            .removeAttr("data-swiper-slide-index")
                            .removeAttr("data-swiper-column")
                            .removeAttr("data-swiper-row")),
                            i.emit("destroy"),
                            Object.keys(i.eventsListeners).forEach(function (e) {
                                i.off(e);
                            }),
                        !1 !== e && ((i.$el[0].swiper = null), i.$el.data("swiper", null), P.deleteProps(i)),
                            (i.destroyed = !0);
                    }),
                    (d.extendDefaults = function (e) {
                        P.extend($, e);
                    }),
                    (e.extendedDefaults.get = function () {
                        return $;
                    }),
                    (e.defaults.get = function () {
                        return S;
                    }),
                    (e.Class.get = function () {
                        return l;
                    }),
                    (e.$.get = function () {
                        return x;
                    }),
                    Object.defineProperties(d, e),
                    d
            );
        })(s),
        v = { name: "device", proto: { device: b }, static: { device: b } },
        g = { name: "support", proto: { support: A }, static: { support: A } },
        w = { name: "browser", proto: { browser: C }, static: { browser: C } },
        y = {
            name: "resize",
            create: function () {
                var e = this;
                P.extend(e, {
                    resize: {
                        resizeHandler: function () {
                            e && !e.destroyed && e.initialized && (e.emit("beforeResize"), e.emit("resize"));
                        },
                        orientationChangeHandler: function () {
                            e && !e.destroyed && e.initialized && e.emit("orientationchange");
                        },
                    },
                });
            },
            on: {
                init: function () {
                    c.addEventListener("resize", this.resize.resizeHandler), c.addEventListener("orientationchange", this.resize.orientationChangeHandler);
                },
                destroy: function () {
                    c.removeEventListener("resize", this.resize.resizeHandler), c.removeEventListener("orientationchange", this.resize.orientationChangeHandler);
                },
            },
        },
        D = {
            func: c.MutationObserver || c.WebkitMutationObserver,
            attach: function (e, t) {
                void 0 === t && (t = {});
                var i = this,
                    n = new D.func(function (e) {
                        e.forEach(function (e) {
                            i.emit("observerUpdate", e);
                        });
                    });
                n.observe(e, { attributes: void 0 === t.attributes || t.attributes, childList: void 0 === t.childList || t.childList, characterData: void 0 === t.characterData || t.characterData }), i.observer.observers.push(n);
            },
            init: function () {
                var e = this;
                if (A.observer && e.params.observer) {
                    if (e.params.observeParents) for (var t = e.$el.parents(), i = 0; i < t.length; i += 1) e.observer.attach(t[i]);
                    e.observer.attach(e.$el[0], { childList: !1 }), e.observer.attach(e.$wrapperEl[0], { attributes: !1 });
                }
            },
            destroy: function () {
                this.observer.observers.forEach(function (e) {
                    e.disconnect();
                }),
                    (this.observer.observers = []);
            },
        },
        t = {
            name: "observer",
            params: { observer: !1, observeParents: !1 },
            create: function () {
                P.extend(this, { observer: { init: D.init.bind(this), attach: D.attach.bind(this), destroy: D.destroy.bind(this), observers: [] } });
            },
            on: {
                init: function () {
                    this.observer.init();
                },
                destroy: function () {
                    this.observer.destroy();
                },
            },
        },
        M = {
            update: function (e) {
                var t = this,
                    i = t.params,
                    n = i.slidesPerView,
                    s = i.slidesPerGroup,
                    a = i.centeredSlides,
                    o = t.virtual,
                    r = o.from,
                    l = o.to,
                    d = o.slides,
                    c = o.slidesGrid,
                    u = o.renderSlide,
                    h = o.offset;
                t.updateActiveIndex();
                var i = t.activeIndex || 0,
                    o = t.rtl && t.isHorizontal() ? "right" : t.isHorizontal() ? "left" : "top",
                    s = a ? ((m = Math.floor(n / 2) + s), Math.floor(n / 2) + s) : ((m = n + (s - 1)), s),
                    p = Math.max((i || 0) - s, 0),
                    f = Math.min((i || 0) + m, d.length - 1),
                    m = (t.slidesGrid[p] || 0) - (t.slidesGrid[0] || 0);
                function v() {
                    t.updateSlides(), t.updateProgress(), t.updateSlidesClasses(), t.lazy && t.params.lazy.enabled && t.lazy.load();
                }
                if ((P.extend(t.virtual, { from: p, to: f, offset: m, slidesGrid: t.slidesGrid }), r === p && l === f && !e)) return t.slidesGrid !== c && m !== h && t.slides.css(o, m + "px"), void t.updateProgress();
                if (t.params.virtual.renderExternal)
                    return (
                        t.params.virtual.renderExternal.call(t, {
                            offset: m,
                            from: p,
                            to: f,
                            slides: (function () {
                                for (var e = [], t = p; t <= f; t += 1) e.push(d[t]);
                                return e;
                            })(),
                        }),
                            void v()
                    );
                var g = [],
                    w = [];
                if (e) t.$wrapperEl.find("." + t.params.slideClass).remove();
                else for (var y = r; y <= l; y += 1) (y < p || f < y) && t.$wrapperEl.find("." + t.params.slideClass + '[data-swiper-slide-index="' + y + '"]').remove();
                for (var b = 0; b < d.length; b += 1) p <= b && b <= f && (void 0 === l || e ? w.push(b) : (l < b && w.push(b), b < r && g.push(b)));
                w.forEach(function (e) {
                    t.$wrapperEl.append(u(d[e], e));
                }),
                    g
                        .sort(function (e, t) {
                            return e < t;
                        })
                        .forEach(function (e) {
                            t.$wrapperEl.prepend(u(d[e], e));
                        }),
                    t.$wrapperEl.children(".swiper-slide").css(o, m + "px"),
                    v();
            },
            renderSlide: function (e, t) {
                var i = this,
                    n = i.params.virtual;
                if (n.cache && i.virtual.cache[t]) return i.virtual.cache[t];
                e = n.renderSlide ? x(n.renderSlide.call(i, e, t)) : x('<div class="' + i.params.slideClass + '" data-swiper-slide-index="' + t + '">' + e + "</div>");
                return e.attr("data-swiper-slide-index") || e.attr("data-swiper-slide-index", t), n.cache && (i.virtual.cache[t] = e), e;
            },
            appendSlide: function (e) {
                this.virtual.slides.push(e), this.virtual.update(!0);
            },
            prependSlide: function (e) {
                var t,
                    i,
                    n = this;
                n.virtual.slides.unshift(e),
                n.params.virtual.cache &&
                ((t = n.virtual.cache),
                    (i = {}),
                    Object.keys(t).forEach(function (e) {
                        i[e + 1] = t[e];
                    }),
                    (n.virtual.cache = i)),
                    n.virtual.update(!0),
                    n.slideNext(0);
            },
        },
        k = {
            name: "virtual",
            params: { virtual: { enabled: !1, slides: [], cache: !0, renderSlide: null, renderExternal: null } },
            create: function () {
                var e = this;
                P.extend(e, { virtual: { update: M.update.bind(e), appendSlide: M.appendSlide.bind(e), prependSlide: M.prependSlide.bind(e), renderSlide: M.renderSlide.bind(e), slides: e.params.virtual.slides, cache: {} } });
            },
            on: {
                beforeInit: function () {
                    var e,
                        t = this;
                    t.params.virtual.enabled && (t.classNames.push(t.params.containerModifierClass + "virtual"), (e = { watchSlidesProgress: !0 }), P.extend(t.params, e), P.extend(t.originalParams, e), t.virtual.update());
                },
                setTranslate: function () {
                    this.params.virtual.enabled && this.virtual.update();
                },
            },
        },
        O = {
            handle: function (e) {
                var t = this,
                    i = e;
                i.originalEvent && (i = i.originalEvent);
                var n = i.keyCode || i.charCode;
                if (!t.allowSlideNext && ((t.isHorizontal() && 39 === n) || (t.isVertical() && 40 === n))) return !1;
                if (!t.allowSlidePrev && ((t.isHorizontal() && 37 === n) || (t.isVertical() && 38 === n))) return !1;
                if (!(i.shiftKey || i.altKey || i.ctrlKey || i.metaKey || (u.activeElement && u.activeElement.nodeName && ("input" === u.activeElement.nodeName.toLowerCase() || "textarea" === u.activeElement.nodeName.toLowerCase())))) {
                    if (t.params.keyboard.onlyInViewport && (37 === n || 39 === n || 38 === n || 40 === n)) {
                        var s = !1;
                        if (0 < t.$el.parents("." + t.params.slideClass).length && 0 === t.$el.parents("." + t.params.slideActiveClass).length) return;
                        var a = c.innerWidth,
                            o = c.innerHeight,
                            e = t.$el.offset();
                        t.rtl && (e.left -= t.$el[0].scrollLeft);
                        for (
                            var r = [
                                    [e.left, e.top],
                                    [e.left + t.width, e.top],
                                    [e.left, e.top + t.height],
                                    [e.left + t.width, e.top + t.height],
                                ],
                                l = 0;
                            l < r.length;
                            l += 1
                        ) {
                            var d = r[l];
                            0 <= d[0] && d[0] <= a && 0 <= d[1] && d[1] <= o && (s = !0);
                        }
                        if (!s) return;
                    }
                    t.isHorizontal()
                        ? ((37 !== n && 39 !== n) || (i.preventDefault ? i.preventDefault() : (i.returnValue = !1)),
                        ((39 === n && !t.rtl) || (37 === n && t.rtl)) && t.slideNext(),
                        ((37 === n && !t.rtl) || (39 === n && t.rtl)) && t.slidePrev())
                        : ((38 !== n && 40 !== n) || (i.preventDefault ? i.preventDefault() : (i.returnValue = !1)), 40 === n && t.slideNext(), 38 === n && t.slidePrev()),
                        t.emit("keyPress", n);
                }
            },
            enable: function () {
                this.keyboard.enabled || (x(u).on("keydown", this.keyboard.handle), (this.keyboard.enabled = !0));
            },
            disable: function () {
                this.keyboard.enabled && (x(u).off("keydown", this.keyboard.handle), (this.keyboard.enabled = !1));
            },
        },
        s = {
            name: "keyboard",
            params: { keyboard: { enabled: !1, onlyInViewport: !0 } },
            create: function () {
                P.extend(this, { keyboard: { enabled: !1, enable: O.enable.bind(this), disable: O.disable.bind(this), handle: O.handle.bind(this) } });
            },
            on: {
                init: function () {
                    this.params.keyboard.enabled && this.keyboard.enable();
                },
                destroy: function () {
                    this.keyboard.enabled && this.keyboard.disable();
                },
            },
        };
    var I,
        z,
        L,
        W = {
            lastScrollTime: P.now(),
            event:
                -1 < c.navigator.userAgent.indexOf("firefox")
                    ? "DOMMouseScroll"
                    : ((L = (z = "onwheel") in u) || ((I = u.createElement("div")).setAttribute(z, "return;"), (L = "function" == typeof I[z])),
                    !L && u.implementation && u.implementation.hasFeature && !0 !== u.implementation.hasFeature("", "") && (L = u.implementation.hasFeature("Events.wheel", "3.0")),
                        L ? "wheel" : "mousewheel"),
            normalize: function (e) {
                var t = 0,
                    i = 0,
                    n = 0,
                    s = 0;
                return (
                    "detail" in e && (i = e.detail),
                    "wheelDelta" in e && (i = -e.wheelDelta / 120),
                    "wheelDeltaY" in e && (i = -e.wheelDeltaY / 120),
                    "wheelDeltaX" in e && (t = -e.wheelDeltaX / 120),
                    "axis" in e && e.axis === e.HORIZONTAL_AXIS && ((t = i), (i = 0)),
                        (n = 10 * t),
                        (s = 10 * i),
                    "deltaY" in e && (s = e.deltaY),
                    "deltaX" in e && (n = e.deltaX),
                    (n || s) && e.deltaMode && (1 === e.deltaMode ? ((n *= 40), (s *= 40)) : ((n *= 800), (s *= 800))),
                    n && !t && (t = n < 1 ? -1 : 1),
                    s && !i && (i = s < 1 ? -1 : 1),
                        { spinX: t, spinY: i, pixelX: n, pixelY: s }
                );
            },
            handle: function (e) {
                var t = e,
                    i = this,
                    n = i.params.mousewheel;
                t.originalEvent && (t = t.originalEvent);
                var s = 0,
                    a = i.rtl ? -1 : 1,
                    o = W.normalize(t);
                if (n.forceToAxis)
                    if (i.isHorizontal()) {
                        if (!(Math.abs(o.pixelX) > Math.abs(o.pixelY))) return !0;
                        s = o.pixelX * a;
                    } else {
                        if (!(Math.abs(o.pixelY) > Math.abs(o.pixelX))) return !0;
                        s = o.pixelY;
                    }
                else s = Math.abs(o.pixelX) > Math.abs(o.pixelY) ? -o.pixelX * a : -o.pixelY;
                if (0 === s) return !0;
                if ((n.invert && (s = -s), i.params.freeMode)) {
                    (e = i.getTranslate() + s * n.sensitivity), (a = i.isBeginning), (o = i.isEnd);
                    if (
                        (e >= i.minTranslate() && (e = i.minTranslate()),
                        e <= i.maxTranslate() && (e = i.maxTranslate()),
                            i.setTransition(0),
                            i.setTranslate(e),
                            i.updateProgress(),
                            i.updateActiveIndex(),
                            i.updateSlidesClasses(),
                        ((!a && i.isBeginning) || (!o && i.isEnd)) && i.updateSlidesClasses(),
                        i.params.freeModeSticky &&
                        (clearTimeout(i.mousewheel.timeout),
                            (i.mousewheel.timeout = P.nextTick(function () {
                                i.slideReset();
                            }, 300))),
                            i.emit("scroll", t),
                        i.params.autoplay && i.params.autoplayDisableOnInteraction && i.stopAutoplay(),
                        e === i.minTranslate() || e === i.maxTranslate())
                    )
                        return !0;
                } else {
                    if (60 < P.now() - i.mousewheel.lastScrollTime)
                        if (s < 0)
                            if ((i.isEnd && !i.params.loop) || i.animating) {
                                if (n.releaseOnEdges) return !0;
                            } else i.slideNext(), i.emit("scroll", t);
                        else if ((i.isBeginning && !i.params.loop) || i.animating) {
                            if (n.releaseOnEdges) return !0;
                        } else i.slidePrev(), i.emit("scroll", t);
                    i.mousewheel.lastScrollTime = new c.Date().getTime();
                }
                return t.preventDefault ? t.preventDefault() : (t.returnValue = !1), !1;
            },
            enable: function () {
                var e = this;
                if (!W.event) return !1;
                if (e.mousewheel.enabled) return !1;
                var t = e.$el;
                return "container" !== e.params.mousewheel.eventsTarged && (t = x(e.params.mousewheel.eventsTarged)), t.on(W.event, e.mousewheel.handle), (e.mousewheel.enabled = !0);
            },
            disable: function () {
                var e = this;
                if (!W.event) return !1;
                if (!e.mousewheel.enabled) return !1;
                var t = e.$el;
                return "container" !== e.params.mousewheel.eventsTarged && (t = x(e.params.mousewheel.eventsTarged)), t.off(W.event, e.mousewheel.handle), !(e.mousewheel.enabled = !1);
            },
        },
        N = {
            update: function () {
                var e,
                    t,
                    i = this,
                    n = i.params.navigation;
                i.params.loop ||
                ((e = (t = i.navigation).$nextEl),
                (t = t.$prevEl) && 0 < t.length && (i.isBeginning ? t.addClass(n.disabledClass) : t.removeClass(n.disabledClass), t[i.params.watchOverflow && i.isLocked ? "addClass" : "removeClass"](n.lockClass)),
                e && 0 < e.length && (i.isEnd ? e.addClass(n.disabledClass) : e.removeClass(n.disabledClass), e[i.params.watchOverflow && i.isLocked ? "addClass" : "removeClass"](n.lockClass)));
            },
            init: function () {
                var e,
                    t,
                    i = this,
                    n = i.params.navigation;
                (n.nextEl || n.prevEl) &&
                (n.nextEl && ((e = x(n.nextEl)), i.params.uniqueNavElements && "string" == typeof n.nextEl && 1 < e.length && 1 === i.$el.find(n.nextEl).length && (e = i.$el.find(n.nextEl))),
                n.prevEl && ((t = x(n.prevEl)), i.params.uniqueNavElements && "string" == typeof n.prevEl && 1 < t.length && 1 === i.$el.find(n.prevEl).length && (t = i.$el.find(n.prevEl))),
                e &&
                0 < e.length &&
                e.on("click", function (e) {
                    e.preventDefault(), (i.isEnd && !i.params.loop) || i.slideNext();
                }),
                t &&
                0 < t.length &&
                t.on("click", function (e) {
                    e.preventDefault(), (i.isBeginning && !i.params.loop) || i.slidePrev();
                }),
                    P.extend(i.navigation, { $nextEl: e, nextEl: e && e[0], $prevEl: t, prevEl: t && t[0] }));
            },
            destroy: function () {
                var e = this.navigation,
                    t = e.$nextEl,
                    e = e.$prevEl;
                t && t.length && (t.off("click"), t.removeClass(this.params.navigation.disabledClass)), e && e.length && (e.off("click"), e.removeClass(this.params.navigation.disabledClass));
            },
        },
        Y = {
            update: function () {
                var e = this,
                    t = e.rtl,
                    n = e.params.pagination;
                if (n.el && e.pagination.el && e.pagination.$el && 0 !== e.pagination.$el.length) {
                    var s,
                        i = (e.virtual && e.params.virtual.enabled ? e.virtual : e).slides.length,
                        a = e.pagination.$el,
                        o = e.params.loop ? Math.ceil((i - 2 * e.loopedSlides) / e.params.slidesPerGroup) : e.snapGrid.length;
                    if (
                        (e.params.loop
                            ? ((s = Math.ceil((e.activeIndex - e.loopedSlides) / e.params.slidesPerGroup)) > i - 1 - 2 * e.loopedSlides && (s -= i - 2 * e.loopedSlides),
                            o - 1 < s && (s -= o),
                            s < 0 && "bullets" !== e.params.paginationType && (s = o + s))
                            : (s = void 0 !== e.snapIndex ? e.snapIndex : e.activeIndex || 0),
                        "bullets" === n.type && e.pagination.bullets && 0 < e.pagination.bullets.length)
                    ) {
                        var r,
                            l,
                            d,
                            c,
                            u,
                            h = e.pagination.bullets;
                        if (
                            (n.dynamicBullets &&
                            ((e.pagination.bulletSize = h.eq(0)[e.isHorizontal() ? "outerWidth" : "outerHeight"](!0)),
                                a.css(e.isHorizontal() ? "width" : "height", e.pagination.bulletSize * (n.dynamicMainBullets + 4) + "px"),
                            1 < n.dynamicMainBullets &&
                            void 0 !== e.previousIndex &&
                            (s > e.previousIndex && e.pagination.dynamicBulletIndex < n.dynamicMainBullets - 1
                                ? (e.pagination.dynamicBulletIndex += 1)
                                : s < e.previousIndex && 0 < e.pagination.dynamicBulletIndex && --e.pagination.dynamicBulletIndex),
                                (r = s - e.pagination.dynamicBulletIndex),
                                (d = ((l = r + (n.dynamicMainBullets - 1)) + r) / 2)),
                                h.removeClass(
                                    n.bulletActiveClass + " " + n.bulletActiveClass + "-next " + n.bulletActiveClass + "-next-next " + n.bulletActiveClass + "-prev " + n.bulletActiveClass + "-prev-prev " + n.bulletActiveClass + "-main"
                                ),
                            1 < a.length)
                        )
                            h.each(function (e, t) {
                                var i = x(t),
                                    t = i.index();
                                t === s && i.addClass(n.bulletActiveClass),
                                n.dynamicBullets &&
                                (r <= t && t <= l && i.addClass(n.bulletActiveClass + "-main"),
                                t === r &&
                                i
                                    .prev()
                                    .addClass(n.bulletActiveClass + "-prev")
                                    .prev()
                                    .addClass(n.bulletActiveClass + "-prev-prev"),
                                t === l &&
                                i
                                    .next()
                                    .addClass(n.bulletActiveClass + "-next")
                                    .next()
                                    .addClass(n.bulletActiveClass + "-next-next"));
                            });
                        else if ((h.eq(s).addClass(n.bulletActiveClass), n.dynamicBullets)) {
                            for (var p = h.eq(r), i = h.eq(l), f = r; f <= l; f += 1) h.eq(f).addClass(n.bulletActiveClass + "-main");
                            p
                                .prev()
                                .addClass(n.bulletActiveClass + "-prev")
                                .prev()
                                .addClass(n.bulletActiveClass + "-prev-prev"),
                                i
                                    .next()
                                    .addClass(n.bulletActiveClass + "-next")
                                    .next()
                                    .addClass(n.bulletActiveClass + "-next-next");
                        }
                        n.dynamicBullets &&
                        ((u = Math.min(h.length, n.dynamicMainBullets + 4)),
                            (c = (e.pagination.bulletSize * u - e.pagination.bulletSize) / 2 - d * e.pagination.bulletSize),
                            (u = t ? "right" : "left"),
                            h.css(e.isHorizontal() ? u : "top", c + "px"));
                    }
                    "fraction" === n.type && (a.find("." + n.currentClass).text(s + 1), a.find("." + n.totalClass).text(o)),
                    "progressbar" === n.type &&
                    ((u = t = (s + 1) / o),
                        (c = 1),
                    e.isHorizontal() || ((c = t), (u = 1)),
                        a
                            .find("." + n.progressbarFillClass)
                            .transform("translate3d(0,0,0) scaleX(" + u + ") scaleY(" + c + ")")
                            .transition(e.params.speed)),
                        "custom" === n.type && n.renderCustom ? (a.html(n.renderCustom(e, s + 1, o)), e.emit("paginationRender", e, a[0])) : e.emit("paginationUpdate", e, a[0]),
                        a[e.params.watchOverflow && e.isLocked ? "addClass" : "removeClass"](n.lockClass);
                }
            },
            render: function () {
                var e = this,
                    t = e.params.pagination;
                if (t.el && e.pagination.el && e.pagination.$el && 0 !== e.pagination.$el.length) {
                    var i = (e.virtual && e.params.virtual.enabled ? e.virtual : e).slides.length,
                        n = e.pagination.$el,
                        s = "";
                    if ("bullets" === t.type) {
                        for (var a = e.params.loop ? Math.ceil((i - 2 * e.loopedSlides) / e.params.slidesPerGroup) : e.snapGrid.length, o = 0; o < a; o += 1)
                            t.renderBullet ? (s += t.renderBullet.call(e, o, t.bulletClass)) : (s += "<" + t.bulletElement + ' class="' + t.bulletClass + '"></' + t.bulletElement + ">");
                        n.html(s), (e.pagination.bullets = n.find("." + t.bulletClass));
                    }
                    "fraction" === t.type && ((s = t.renderFraction ? t.renderFraction.call(e, t.currentClass, t.totalClass) : '<span class="' + t.currentClass + '"></span> / <span class="' + t.totalClass + '"></span>'), n.html(s)),
                    "progressbar" === t.type && ((s = t.renderProgressbar ? t.renderProgressbar.call(e, t.progressbarFillClass) : '<span class="' + t.progressbarFillClass + '"></span>'), n.html(s)),
                    "custom" !== t.type && e.emit("paginationRender", e.pagination.$el[0]);
                }
            },
            init: function () {
                var e,
                    t = this,
                    i = t.params.pagination;
                !i.el ||
                (0 !== (e = x(i.el)).length &&
                    (t.params.uniqueNavElements && "string" == typeof i.el && 1 < e.length && 1 === t.$el.find(i.el).length && (e = t.$el.find(i.el)),
                    "bullets" === i.type && i.clickable && e.addClass(i.clickableClass),
                        e.addClass(i.modifierClass + i.type),
                    "bullets" === i.type && i.dynamicBullets && (e.addClass("" + i.modifierClass + i.type + "-dynamic"), (t.pagination.dynamicBulletIndex = 0), i.dynamicMainBullets < 1 && (i.dynamicMainBullets = 1)),
                    i.clickable &&
                    e.on("click", "." + i.bulletClass, function (e) {
                        e.preventDefault();
                        e = x(this).index() * t.params.slidesPerGroup;
                        t.params.loop && (e += t.loopedSlides), t.slideTo(e);
                    }),
                        P.extend(t.pagination, { $el: e, el: e[0] })));
            },
            destroy: function () {
                var e,
                    t = this,
                    i = t.params.pagination;
                i.el &&
                t.pagination.el &&
                t.pagination.$el &&
                0 !== t.pagination.$el.length &&
                ((e = t.pagination.$el).removeClass(i.hiddenClass),
                    e.removeClass(i.modifierClass + i.type),
                t.pagination.bullets && t.pagination.bullets.removeClass(i.bulletActiveClass),
                i.clickable && e.off("click", "." + i.bulletClass));
            },
        },
        j = {
            setTranslate: function () {
                var e,
                    t,
                    i,
                    n,
                    s,
                    a,
                    o,
                    r,
                    l = this;
                l.params.scrollbar.el &&
                l.scrollbar.el &&
                ((o = l.scrollbar),
                    (e = l.rtl),
                    (r = l.progress),
                    (t = o.dragSize),
                    (i = o.trackSize),
                    (n = o.$dragEl),
                    (s = o.$el),
                    (a = l.params.scrollbar),
                    (r = (i - (o = t)) * r),
                    e && l.isHorizontal() ? (0 < (r = -r) ? ((o = t - r), (r = 0)) : i < -r + t && (o = i + r)) : r < 0 ? ((o = t + r), (r = 0)) : i < r + t && (o = i - r),
                    l.isHorizontal()
                        ? (A.transforms3d ? n.transform("translate3d(" + r + "px, 0, 0)") : n.transform("translateX(" + r + "px)"), (n[0].style.width = o + "px"))
                        : (A.transforms3d ? n.transform("translate3d(0px, " + r + "px, 0)") : n.transform("translateY(" + r + "px)"), (n[0].style.height = o + "px")),
                a.hide &&
                (clearTimeout(l.scrollbar.timeout),
                    (s[0].style.opacity = 1),
                    (l.scrollbar.timeout = setTimeout(function () {
                        (s[0].style.opacity = 0), s.transition(400);
                    }, 1e3))));
            },
            setTransition: function (e) {
                this.params.scrollbar.el && this.scrollbar.el && this.scrollbar.$dragEl.transition(e);
            },
            updateSize: function () {
                var e,
                    t,
                    i,
                    n,
                    s,
                    a,
                    o,
                    r = this;
                r.params.scrollbar.el &&
                r.scrollbar.el &&
                ((t = (e = r.scrollbar).$dragEl),
                    (i = e.$el),
                    (t[0].style.width = ""),
                    (t[0].style.height = ""),
                    (n = r.isHorizontal() ? i[0].offsetWidth : i[0].offsetHeight),
                    (a = (s = r.size / r.virtualSize) * (n / r.size)),
                    (o = "auto" === r.params.scrollbar.dragSize ? n * s : parseInt(r.params.scrollbar.dragSize, 10)),
                    r.isHorizontal() ? (t[0].style.width = o + "px") : (t[0].style.height = o + "px"),
                    (i[0].style.display = 1 <= s ? "none" : ""),
                r.params.scrollbarHide && (i[0].style.opacity = 0),
                    P.extend(e, { trackSize: n, divider: s, moveDivider: a, dragSize: o }),
                    e.$el[r.params.watchOverflow && r.isLocked ? "addClass" : "removeClass"](r.params.scrollbar.lockClass));
            },
            setDragPosition: function (e) {
                var t = this,
                    i = t.scrollbar,
                    n = i.$el,
                    s = i.dragSize,
                    i = i.trackSize,
                    e = t.isHorizontal()
                        ? "touchstart" === e.type || "touchmove" === e.type
                            ? e.targetTouches[0].pageX
                            : e.pageX || e.clientX
                        : "touchstart" === e.type || "touchmove" === e.type
                            ? e.targetTouches[0].pageY
                            : e.pageY || e.clientY,
                    s = (e - n.offset()[t.isHorizontal() ? "left" : "top"] - s / 2) / (i - s);
                (s = Math.max(Math.min(s, 1), 0)), t.rtl && (s = 1 - s);
                s = t.minTranslate() + (t.maxTranslate() - t.minTranslate()) * s;
                t.updateProgress(s), t.setTranslate(s), t.updateActiveIndex(), t.updateSlidesClasses();
            },
            onDragStart: function (e) {
                var t = this,
                    i = t.params.scrollbar,
                    n = t.scrollbar,
                    s = t.$wrapperEl,
                    a = n.$el,
                    o = n.$dragEl;
                (t.scrollbar.isTouched = !0),
                    e.preventDefault(),
                    e.stopPropagation(),
                    s.transition(100),
                    o.transition(100),
                    n.setDragPosition(e),
                    clearTimeout(t.scrollbar.dragTimeout),
                    a.transition(0),
                i.hide && a.css("opacity", 1),
                    t.emit("scrollbarDragStart", e);
            },
            onDragMove: function (e) {
                var t = this.scrollbar,
                    i = this.$wrapperEl,
                    n = t.$el,
                    s = t.$dragEl;
                this.scrollbar.isTouched && (e.preventDefault ? e.preventDefault() : (e.returnValue = !1), t.setDragPosition(e), i.transition(0), n.transition(0), s.transition(0), this.emit("scrollbarDragMove", e));
            },
            onDragEnd: function (e) {
                var t = this,
                    i = t.params.scrollbar,
                    n = t.scrollbar.$el;
                t.scrollbar.isTouched &&
                ((t.scrollbar.isTouched = !1),
                i.hide &&
                (clearTimeout(t.scrollbar.dragTimeout),
                    (t.scrollbar.dragTimeout = P.nextTick(function () {
                        n.css("opacity", 0), n.transition(400);
                    }, 1e3))),
                    t.emit("scrollbarDragEnd", e),
                i.snapOnRelease && t.slideReset());
            },
            enableDraggable: function () {
                var e,
                    t,
                    i,
                    n,
                    s,
                    a,
                    o = this;
                o.params.scrollbar.el &&
                ((a = o.scrollbar),
                    (e = o.touchEvents),
                    (t = o.touchEventsDesktop),
                    (i = o.params),
                    (n = a.$el[0]),
                    (s = !(!A.passiveListener || !i.passiveListener) && { passive: !1, capture: !1 }),
                    (a = !(!A.passiveListener || !i.passiveListener) && { passive: !0, capture: !1 }),
                    A.touch || (!A.pointerEvents && !A.prefixedPointerEvents)
                        ? (A.touch && (n.addEventListener(e.start, o.scrollbar.onDragStart, s), n.addEventListener(e.move, o.scrollbar.onDragMove, s), n.addEventListener(e.end, o.scrollbar.onDragEnd, a)),
                        ((i.simulateTouch && !b.ios && !b.android) || (i.simulateTouch && !A.touch && b.ios)) &&
                        (n.addEventListener("mousedown", o.scrollbar.onDragStart, s), u.addEventListener("mousemove", o.scrollbar.onDragMove, s), u.addEventListener("mouseup", o.scrollbar.onDragEnd, a)))
                        : (n.addEventListener(t.start, o.scrollbar.onDragStart, s), u.addEventListener(t.move, o.scrollbar.onDragMove, s), u.addEventListener(t.end, o.scrollbar.onDragEnd, a)));
            },
            disableDraggable: function () {
                var e,
                    t,
                    i,
                    n,
                    s,
                    a,
                    o = this;
                o.params.scrollbar.el &&
                ((a = o.scrollbar),
                    (e = o.touchEvents),
                    (t = o.touchEventsDesktop),
                    (i = o.params),
                    (n = a.$el[0]),
                    (s = !(!A.passiveListener || !i.passiveListener) && { passive: !1, capture: !1 }),
                    (a = !(!A.passiveListener || !i.passiveListener) && { passive: !0, capture: !1 }),
                    A.touch || (!A.pointerEvents && !A.prefixedPointerEvents)
                        ? (A.touch && (n.removeEventListener(e.start, o.scrollbar.onDragStart, s), n.removeEventListener(e.move, o.scrollbar.onDragMove, s), n.removeEventListener(e.end, o.scrollbar.onDragEnd, a)),
                        ((i.simulateTouch && !b.ios && !b.android) || (i.simulateTouch && !A.touch && b.ios)) &&
                        (n.removeEventListener("mousedown", o.scrollbar.onDragStart, s), u.removeEventListener("mousemove", o.scrollbar.onDragMove, s), u.removeEventListener("mouseup", o.scrollbar.onDragEnd, a)))
                        : (n.removeEventListener(t.start, o.scrollbar.onDragStart, s), u.removeEventListener(t.move, o.scrollbar.onDragMove, s), u.removeEventListener(t.end, o.scrollbar.onDragEnd, a)));
            },
            init: function () {
                var e,
                    t,
                    i,
                    n,
                    s = this;
                s.params.scrollbar.el &&
                ((e = s.scrollbar),
                    (n = s.$el),
                    (i = x((t = s.params.scrollbar).el)),
                s.params.uniqueNavElements && "string" == typeof t.el && 1 < i.length && 1 === n.find(t.el).length && (i = n.find(t.el)),
                0 === (n = i.find("." + s.params.scrollbar.dragClass)).length && ((n = x('<div class="' + s.params.scrollbar.dragClass + '"></div>')), i.append(n)),
                    P.extend(e, { $el: i, el: i[0], $dragEl: n, dragEl: n[0] }),
                t.draggable && e.enableDraggable());
            },
            destroy: function () {
                this.scrollbar.disableDraggable();
            },
        },
        H = {
            setTransform: function (e, t) {
                var i = this.rtl,
                    n = x(e),
                    s = i ? -1 : 1,
                    a = n.attr("data-swiper-parallax") || "0",
                    o = n.attr("data-swiper-parallax-x"),
                    r = n.attr("data-swiper-parallax-y"),
                    e = n.attr("data-swiper-parallax-scale"),
                    i = n.attr("data-swiper-parallax-opacity");
                o || r ? ((o = o || "0"), (r = r || "0")) : this.isHorizontal() ? ((o = a), (r = "0")) : ((r = a), (o = "0")),
                    (o = 0 <= o.indexOf("%") ? parseInt(o, 10) * t * s + "%" : o * t * s + "px"),
                    (r = 0 <= r.indexOf("%") ? parseInt(r, 10) * t + "%" : r * t + "px"),
                null != i && ((i = i - (i - 1) * (1 - Math.abs(t))), (n[0].style.opacity = i)),
                    null == e ? n.transform("translate3d(" + o + ", " + r + ", 0px)") : ((t = e - (e - 1) * (1 - Math.abs(t))), n.transform("translate3d(" + o + ", " + r + ", 0px) scale(" + t + ")"));
            },
            setTranslate: function () {
                var n = this,
                    e = n.$el,
                    t = n.slides,
                    s = n.progress,
                    a = n.snapGrid;
                e.children("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function (e, t) {
                    n.parallax.setTransform(t, s);
                }),
                    t.each(function (e, t) {
                        var i = t.progress;
                        1 < n.params.slidesPerGroup && "auto" !== n.params.slidesPerView && (i += Math.ceil(e / 2) - s * (a.length - 1)),
                            (i = Math.min(Math.max(i, -1), 1)),
                            x(t)
                                .find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]")
                                .each(function (e, t) {
                                    n.parallax.setTransform(t, i);
                                });
                    });
            },
            setTransition: function (n) {
                void 0 === n && (n = this.params.speed);
                this.$el.find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function (e, t) {
                    var i = x(t),
                        t = parseInt(i.attr("data-swiper-parallax-duration"), 10) || n;
                    0 === n && (t = 0), i.transition(t);
                });
            },
        },
        R = {
            getDistanceBetweenTouches: function (e) {
                if (e.targetTouches.length < 2) return 1;
                var t = e.targetTouches[0].pageX,
                    i = e.targetTouches[0].pageY,
                    n = e.targetTouches[1].pageX,
                    e = e.targetTouches[1].pageY;
                return Math.sqrt(Math.pow(n - t, 2) + Math.pow(e - i, 2));
            },
            onGestureStart: function (e) {
                var t = this,
                    i = t.params.zoom,
                    n = t.zoom,
                    s = n.gesture;
                if (((n.fakeGestureTouched = !1), (n.fakeGestureMoved = !1), !A.gestures)) {
                    if ("touchstart" !== e.type || ("touchstart" === e.type && e.targetTouches.length < 2)) return;
                    (n.fakeGestureTouched = !0), (s.scaleStart = R.getDistanceBetweenTouches(e));
                }
                (s.$slideEl && s.$slideEl.length) ||
                ((s.$slideEl = x(e.target).closest(".swiper-slide")),
                0 === s.$slideEl.length && (s.$slideEl = t.slides.eq(t.activeIndex)),
                    (s.$imageEl = s.$slideEl.find("img, svg, canvas")),
                    (s.$imageWrapEl = s.$imageEl.parent("." + i.containerClass)),
                    (s.maxRatio = s.$imageWrapEl.attr("data-swiper-zoom") || i.maxRatio),
                0 !== s.$imageWrapEl.length)
                    ? (s.$imageEl.transition(0), (t.zoom.isScaling = !0))
                    : (s.$imageEl = void 0);
            },
            onGestureChange: function (e) {
                var t = this.params.zoom,
                    i = this.zoom,
                    n = i.gesture;
                if (!A.gestures) {
                    if ("touchmove" !== e.type || ("touchmove" === e.type && e.targetTouches.length < 2)) return;
                    (i.fakeGestureMoved = !0), (n.scaleMove = R.getDistanceBetweenTouches(e));
                }
                n.$imageEl &&
                0 !== n.$imageEl.length &&
                (A.gestures ? (this.zoom.scale = e.scale * i.currentScale) : (i.scale = (n.scaleMove / n.scaleStart) * i.currentScale),
                i.scale > n.maxRatio && (i.scale = n.maxRatio - 1 + Math.pow(i.scale - n.maxRatio + 1, 0.5)),
                i.scale < t.minRatio && (i.scale = t.minRatio + 1 - Math.pow(t.minRatio - i.scale + 1, 0.5)),
                    n.$imageEl.transform("translate3d(0,0,0) scale(" + i.scale + ")"));
            },
            onGestureEnd: function (e) {
                var t = this.params.zoom,
                    i = this.zoom,
                    n = i.gesture;
                if (!A.gestures) {
                    if (!i.fakeGestureTouched || !i.fakeGestureMoved) return;
                    if ("touchend" !== e.type || ("touchend" === e.type && e.changedTouches.length < 2 && !b.android)) return;
                    (i.fakeGestureTouched = !1), (i.fakeGestureMoved = !1);
                }
                n.$imageEl &&
                0 !== n.$imageEl.length &&
                ((i.scale = Math.max(Math.min(i.scale, n.maxRatio), t.minRatio)),
                    n.$imageEl.transition(this.params.speed).transform("translate3d(0,0,0) scale(" + i.scale + ")"),
                    (i.currentScale = i.scale),
                    (i.isScaling = !1),
                1 === i.scale && (n.$slideEl = void 0));
            },
            onTouchStart: function (e) {
                var t = this.zoom,
                    i = t.gesture,
                    t = t.image;
                i.$imageEl &&
                0 !== i.$imageEl.length &&
                (t.isTouched ||
                    (b.android && e.preventDefault(), (t.isTouched = !0), (t.touchesStart.x = ("touchstart" === e.type ? e.targetTouches[0] : e).pageX), (t.touchesStart.y = ("touchstart" === e.type ? e.targetTouches[0] : e).pageY)));
            },
            onTouchMove: function (e) {
                var t = this,
                    i = t.zoom,
                    n = i.gesture,
                    s = i.image,
                    a = i.velocity;
                if (n.$imageEl && 0 !== n.$imageEl.length && ((t.allowClick = !1), s.isTouched && n.$slideEl)) {
                    s.isMoved ||
                    ((s.width = n.$imageEl[0].offsetWidth),
                        (s.height = n.$imageEl[0].offsetHeight),
                        (s.startX = P.getTranslate(n.$imageWrapEl[0], "x") || 0),
                        (s.startY = P.getTranslate(n.$imageWrapEl[0], "y") || 0),
                        (n.slideWidth = n.$slideEl[0].offsetWidth),
                        (n.slideHeight = n.$slideEl[0].offsetHeight),
                        n.$imageWrapEl.transition(0),
                    t.rtl && (s.startX = -s.startX),
                    t.rtl && (s.startY = -s.startY));
                    var o = s.width * i.scale,
                        r = s.height * i.scale;
                    if (!(o < n.slideWidth && r < n.slideHeight)) {
                        if (
                            ((s.minX = Math.min(n.slideWidth / 2 - o / 2, 0)),
                                (s.maxX = -s.minX),
                                (s.minY = Math.min(n.slideHeight / 2 - r / 2, 0)),
                                (s.maxY = -s.minY),
                                (s.touchesCurrent.x = ("touchmove" === e.type ? e.targetTouches[0] : e).pageX),
                                (s.touchesCurrent.y = ("touchmove" === e.type ? e.targetTouches[0] : e).pageY),
                            !s.isMoved && !i.isScaling)
                        ) {
                            if (t.isHorizontal() && ((Math.floor(s.minX) === Math.floor(s.startX) && s.touchesCurrent.x < s.touchesStart.x) || (Math.floor(s.maxX) === Math.floor(s.startX) && s.touchesCurrent.x > s.touchesStart.x)))
                                return void (s.isTouched = !1);
                            if (!t.isHorizontal() && ((Math.floor(s.minY) === Math.floor(s.startY) && s.touchesCurrent.y < s.touchesStart.y) || (Math.floor(s.maxY) === Math.floor(s.startY) && s.touchesCurrent.y > s.touchesStart.y)))
                                return void (s.isTouched = !1);
                        }
                        e.preventDefault(),
                            e.stopPropagation(),
                            (s.isMoved = !0),
                            (s.currentX = s.touchesCurrent.x - s.touchesStart.x + s.startX),
                            (s.currentY = s.touchesCurrent.y - s.touchesStart.y + s.startY),
                        s.currentX < s.minX && (s.currentX = s.minX + 1 - Math.pow(s.minX - s.currentX + 1, 0.8)),
                        s.currentX > s.maxX && (s.currentX = s.maxX - 1 + Math.pow(s.currentX - s.maxX + 1, 0.8)),
                        s.currentY < s.minY && (s.currentY = s.minY + 1 - Math.pow(s.minY - s.currentY + 1, 0.8)),
                        s.currentY > s.maxY && (s.currentY = s.maxY - 1 + Math.pow(s.currentY - s.maxY + 1, 0.8)),
                        a.prevPositionX || (a.prevPositionX = s.touchesCurrent.x),
                        a.prevPositionY || (a.prevPositionY = s.touchesCurrent.y),
                        a.prevTime || (a.prevTime = Date.now()),
                            (a.x = (s.touchesCurrent.x - a.prevPositionX) / (Date.now() - a.prevTime) / 2),
                            (a.y = (s.touchesCurrent.y - a.prevPositionY) / (Date.now() - a.prevTime) / 2),
                        Math.abs(s.touchesCurrent.x - a.prevPositionX) < 2 && (a.x = 0),
                        Math.abs(s.touchesCurrent.y - a.prevPositionY) < 2 && (a.y = 0),
                            (a.prevPositionX = s.touchesCurrent.x),
                            (a.prevPositionY = s.touchesCurrent.y),
                            (a.prevTime = Date.now()),
                            n.$imageWrapEl.transform("translate3d(" + s.currentX + "px, " + s.currentY + "px,0)");
                    }
                }
            },
            onTouchEnd: function () {
                var e = this.zoom,
                    t = e.gesture,
                    i = e.image,
                    n = e.velocity;
                if (t.$imageEl && 0 !== t.$imageEl.length) {
                    if (!i.isTouched || !i.isMoved) return (i.isTouched = !1), void (i.isMoved = !1);
                    (i.isTouched = !1), (i.isMoved = !1);
                    var s = 300,
                        a = 300,
                        o = n.x * s,
                        r = i.currentX + o,
                        o = n.y * a,
                        o = i.currentY + o;
                    0 !== n.x && (s = Math.abs((r - i.currentX) / n.x)), 0 !== n.y && (a = Math.abs((o - i.currentY) / n.y));
                    a = Math.max(s, a);
                    (i.currentX = r), (i.currentY = o);
                    (o = i.width * e.scale), (e = i.height * e.scale);
                    (i.minX = Math.min(t.slideWidth / 2 - o / 2, 0)),
                        (i.maxX = -i.minX),
                        (i.minY = Math.min(t.slideHeight / 2 - e / 2, 0)),
                        (i.maxY = -i.minY),
                        (i.currentX = Math.max(Math.min(i.currentX, i.maxX), i.minX)),
                        (i.currentY = Math.max(Math.min(i.currentY, i.maxY), i.minY)),
                        t.$imageWrapEl.transition(a).transform("translate3d(" + i.currentX + "px, " + i.currentY + "px,0)");
                }
            },
            onTransitionEnd: function () {
                var e = this.zoom,
                    t = e.gesture;
                t.$slideEl &&
                this.previousIndex !== this.activeIndex &&
                (t.$imageEl.transform("translate3d(0,0,0) scale(1)"), t.$imageWrapEl.transform("translate3d(0,0,0)"), (t.$slideEl = void 0), (t.$imageEl = void 0), (t.$imageWrapEl = void 0), (e.scale = 1), (e.currentScale = 1));
            },
            toggle: function (e) {
                var t = this.zoom;
                t.scale && 1 !== t.scale ? t.out() : t.in(e);
            },
            in: function (e) {
                var t,
                    i,
                    n,
                    s = this,
                    a = s.zoom,
                    o = s.params.zoom,
                    r = a.gesture,
                    l = a.image;
                r.$slideEl || ((r.$slideEl = s.clickedSlide ? x(s.clickedSlide) : s.slides.eq(s.activeIndex)), (r.$imageEl = r.$slideEl.find("img, svg, canvas")), (r.$imageWrapEl = r.$imageEl.parent("." + o.containerClass))),
                r.$imageEl &&
                0 !== r.$imageEl.length &&
                (r.$slideEl.addClass("" + o.zoomedSlideClass),
                    (l = void 0 === l.touchesStart.x && e ? ((n = ("touchend" === e.type ? e.changedTouches[0] : e).pageX), ("touchend" === e.type ? e.changedTouches[0] : e).pageY) : ((n = l.touchesStart.x), l.touchesStart.y)),
                    (a.scale = r.$imageWrapEl.attr("data-swiper-zoom") || o.maxRatio),
                    (a.currentScale = r.$imageWrapEl.attr("data-swiper-zoom") || o.maxRatio),
                    e
                        ? ((o = r.$slideEl[0].offsetWidth),
                            (e = r.$slideEl[0].offsetHeight),
                            (t = r.$slideEl.offset().left + o / 2 - n),
                            (i = r.$slideEl.offset().top + e / 2 - l),
                            (n = r.$imageEl[0].offsetWidth),
                            (l = r.$imageEl[0].offsetHeight),
                            (n = n * a.scale),
                            (l = l * a.scale),
                            (n = -(o = Math.min(o / 2 - n / 2, 0))),
                            (l = -(e = Math.min(e / 2 - l / 2, 0))),
                        (t = t * a.scale) < o && (t = o),
                        n < t && (t = n),
                        (i = i * a.scale) < e && (i = e),
                        l < i && (i = l))
                        : (i = t = 0),
                    r.$imageWrapEl.transition(300).transform("translate3d(" + t + "px, " + i + "px,0)"),
                    r.$imageEl.transition(300).transform("translate3d(0,0,0) scale(" + a.scale + ")"));
            },
            out: function () {
                var e = this,
                    t = e.zoom,
                    i = e.params.zoom,
                    n = t.gesture;
                n.$slideEl || ((n.$slideEl = e.clickedSlide ? x(e.clickedSlide) : e.slides.eq(e.activeIndex)), (n.$imageEl = n.$slideEl.find("img, svg, canvas")), (n.$imageWrapEl = n.$imageEl.parent("." + i.containerClass))),
                n.$imageEl &&
                0 !== n.$imageEl.length &&
                ((t.scale = 1),
                    (t.currentScale = 1),
                    n.$imageWrapEl.transition(300).transform("translate3d(0,0,0)"),
                    n.$imageEl.transition(300).transform("translate3d(0,0,0) scale(1)"),
                    n.$slideEl.removeClass("" + i.zoomedSlideClass),
                    (n.$slideEl = void 0));
            },
            enable: function () {
                var e,
                    t = this,
                    i = t.zoom;
                i.enabled ||
                ((i.enabled = !0),
                    (e = !("touchstart" !== t.touchEvents.start || !A.passiveListener || !t.params.passiveListeners) && { passive: !0, capture: !1 }),
                    A.gestures
                        ? (t.$wrapperEl.on("gesturestart", ".swiper-slide", i.onGestureStart, e), t.$wrapperEl.on("gesturechange", ".swiper-slide", i.onGestureChange, e), t.$wrapperEl.on("gestureend", ".swiper-slide", i.onGestureEnd, e))
                        : "touchstart" === t.touchEvents.start &&
                        (t.$wrapperEl.on(t.touchEvents.start, ".swiper-slide", i.onGestureStart, e),
                            t.$wrapperEl.on(t.touchEvents.move, ".swiper-slide", i.onGestureChange, e),
                            t.$wrapperEl.on(t.touchEvents.end, ".swiper-slide", i.onGestureEnd, e)),
                    t.$wrapperEl.on(t.touchEvents.move, "." + t.params.zoom.containerClass, i.onTouchMove));
            },
            disable: function () {
                var e,
                    t = this,
                    i = t.zoom;
                i.enabled &&
                ((t.zoom.enabled = !1),
                    (e = !("touchstart" !== t.touchEvents.start || !A.passiveListener || !t.params.passiveListeners) && { passive: !0, capture: !1 }),
                    A.gestures
                        ? (t.$wrapperEl.off("gesturestart", ".swiper-slide", i.onGestureStart, e), t.$wrapperEl.off("gesturechange", ".swiper-slide", i.onGestureChange, e), t.$wrapperEl.off("gestureend", ".swiper-slide", i.onGestureEnd, e))
                        : "touchstart" === t.touchEvents.start &&
                        (t.$wrapperEl.off(t.touchEvents.start, ".swiper-slide", i.onGestureStart, e),
                            t.$wrapperEl.off(t.touchEvents.move, ".swiper-slide", i.onGestureChange, e),
                            t.$wrapperEl.off(t.touchEvents.end, ".swiper-slide", i.onGestureEnd, e)),
                    t.$wrapperEl.off(t.touchEvents.move, "." + t.params.zoom.containerClass, i.onTouchMove));
            },
        },
        F = {
            loadInSlide: function (e, r) {
                void 0 === r && (r = !0);
                var l,
                    d = this,
                    c = d.params.lazy;
                void 0 !== e &&
                0 !== d.slides.length &&
                ((e = (l = d.virtual && d.params.virtual.enabled ? d.$wrapperEl.children("." + d.params.slideClass + '[data-swiper-slide-index="' + e + '"]') : d.slides.eq(e)).find(
                    "." + c.elementClass + ":not(." + c.loadedClass + "):not(." + c.loadingClass + ")"
                )),
                !l.hasClass(c.elementClass) || l.hasClass(c.loadedClass) || l.hasClass(c.loadingClass) || (e = e.add(l[0])),
                0 !== e.length &&
                e.each(function (e, t) {
                    var i = x(t);
                    i.addClass(c.loadingClass);
                    var n = i.attr("data-background"),
                        s = i.attr("data-src"),
                        a = i.attr("data-srcset"),
                        o = i.attr("data-sizes");
                    d.loadImage(i[0], s || n, a, o, !1, function () {
                        var e, t;
                        null == d ||
                        !d ||
                        (d && !d.params) ||
                        d.destroyed ||
                        (n
                            ? (i.css("background-image", 'url("' + n + '")'), i.removeAttr("data-background"))
                            : (a && (i.attr("srcset", a), i.removeAttr("data-srcset")), o && (i.attr("sizes", o), i.removeAttr("data-sizes")), s && (i.attr("src", s), i.removeAttr("data-src"))),
                            i.addClass(c.loadedClass).removeClass(c.loadingClass),
                            l.find("." + c.preloaderClass).remove(),
                        d.params.loop &&
                        r &&
                        ((t = l.attr("data-swiper-slide-index")),
                            l.hasClass(d.params.slideDuplicateClass)
                                ? ((e = d.$wrapperEl.children('[data-swiper-slide-index="' + t + '"]:not(.' + d.params.slideDuplicateClass + ")")), d.lazy.loadInSlide(e.index(), !1))
                                : ((t = d.$wrapperEl.children("." + d.params.slideDuplicateClass + '[data-swiper-slide-index="' + t + '"]')), d.lazy.loadInSlide(t.index(), !1))),
                            d.emit("lazyImageReady", l[0], i[0]));
                    }),
                        d.emit("lazyImageLoad", l[0], i[0]);
                }));
            },
            load: function () {
                var i = this,
                    t = i.$wrapperEl,
                    n = i.params,
                    s = i.slides,
                    e = i.activeIndex,
                    a = i.virtual && n.virtual.enabled,
                    o = n.lazy,
                    r = n.slidesPerView;
                function l(e) {
                    if (a) {
                        if (t.children("." + n.slideClass + '[data-swiper-slide-index="' + e + '"]').length) return 1;
                    } else if (s[e]) return 1;
                }
                function d(e) {
                    return a ? x(e).attr("data-swiper-slide-index") : x(e).index();
                }
                if (("auto" === r && (r = 0), i.lazy.initialImageLoaded || (i.lazy.initialImageLoaded = !0), i.params.watchSlidesVisibility))
                    t.children("." + n.slideVisibleClass).each(function (e, t) {
                        t = a ? x(t).attr("data-swiper-slide-index") : x(t).index();
                        i.lazy.loadInSlide(t);
                    });
                else if (1 < r) for (var c = e; c < e + r; c += 1) l(c) && i.lazy.loadInSlide(c);
                else i.lazy.loadInSlide(e);
                if (o.loadPrevNext)
                    if (1 < r || (o.loadPrevNextAmount && 1 < o.loadPrevNextAmount)) {
                        for (var u = o.loadPrevNextAmount, o = r, h = Math.min(e + o + Math.max(u, o), s.length), u = Math.max(e - Math.max(o, u), 0), p = e + r; p < h; p += 1) l(p) && i.lazy.loadInSlide(p);
                        for (var f = u; f < e; f += 1) l(f) && i.lazy.loadInSlide(f);
                    } else {
                        u = t.children("." + n.slideNextClass);
                        0 < u.length && i.lazy.loadInSlide(d(u));
                        u = t.children("." + n.slidePrevClass);
                        0 < u.length && i.lazy.loadInSlide(d(u));
                    }
            },
        },
        B = {
            LinearSpline: function (e, t) {
                var i,
                    n,
                    s,
                    a,
                    o,
                    r = function (e, t) {
                        for (n = -1, i = e.length; 1 < i - n; ) e[(s = (i + n) >> 1)] <= t ? (n = s) : (i = s);
                        return i;
                    };
                return (
                    (this.x = e),
                        (this.y = t),
                        (this.lastIndex = e.length - 1),
                        (this.interpolate = function (e) {
                            return e ? ((o = r(this.x, e)), (a = o - 1), ((e - this.x[a]) * (this.y[o] - this.y[a])) / (this.x[o] - this.x[a]) + this.y[a]) : 0;
                        }),
                        this
                );
            },
            getInterpolateFunction: function (e) {
                var t = this;
                t.controller.spline || (t.controller.spline = t.params.loop ? new B.LinearSpline(t.slidesGrid, e.slidesGrid) : new B.LinearSpline(t.snapGrid, e.snapGrid));
            },
            setTranslate: function (e, t) {
                var i,
                    n,
                    s = this,
                    a = s.controller.control;
                function o(e) {
                    var t = e.rtl && "horizontal" === e.params.direction ? -s.translate : s.translate;
                    "slide" === s.params.controller.by && (s.controller.getInterpolateFunction(e), (n = -s.controller.spline.interpolate(-t))),
                    (n && "container" !== s.params.controller.by) || ((i = (e.maxTranslate() - e.minTranslate()) / (s.maxTranslate() - s.minTranslate())), (n = (t - s.minTranslate()) * i + e.minTranslate())),
                    s.params.controller.inverse && (n = e.maxTranslate() - n),
                        e.updateProgress(n),
                        e.setTranslate(n, s),
                        e.updateActiveIndex(),
                        e.updateSlidesClasses();
                }
                if (Array.isArray(a)) for (var r = 0; r < a.length; r += 1) a[r] !== t && a[r] instanceof E && o(a[r]);
                else a instanceof E && t !== a && o(a);
            },
            setTransition: function (t, e) {
                var i,
                    n = this,
                    s = n.controller.control;
                function a(e) {
                    e.setTransition(t, n),
                    0 !== t &&
                    (e.transitionStart(),
                        e.$wrapperEl.transitionEnd(function () {
                            s && (e.params.loop && "slide" === n.params.controller.by && e.loopFix(), e.transitionEnd());
                        }));
                }
                if (Array.isArray(s)) for (i = 0; i < s.length; i += 1) s[i] !== e && s[i] instanceof E && a(s[i]);
                else s instanceof E && e !== s && a(s);
            },
        },
        V = {
            makeElFocusable: function (e) {
                return e.attr("tabIndex", "0"), e;
            },
            addElRole: function (e, t) {
                return e.attr("role", t), e;
            },
            addElLabel: function (e, t) {
                return e.attr("aria-label", t), e;
            },
            disableEl: function (e) {
                return e.attr("aria-disabled", !0), e;
            },
            enableEl: function (e) {
                return e.attr("aria-disabled", !1), e;
            },
            onEnterKey: function (e) {
                var t = this,
                    i = t.params.a11y;
                13 === e.keyCode &&
                ((e = x(e.target)),
                t.navigation && t.navigation.$nextEl && e.is(t.navigation.$nextEl) && ((t.isEnd && !t.params.loop) || t.slideNext(), t.isEnd ? t.a11y.notify(i.lastSlideMessage) : t.a11y.notify(i.nextSlideMessage)),
                t.navigation && t.navigation.$prevEl && e.is(t.navigation.$prevEl) && ((t.isBeginning && !t.params.loop) || t.slidePrev(), t.isBeginning ? t.a11y.notify(i.firstSlideMessage) : t.a11y.notify(i.prevSlideMessage)),
                t.pagination && e.is("." + t.params.pagination.bulletClass) && e[0].click());
            },
            notify: function (e) {
                var t = this.a11y.liveRegion;
                0 !== t.length && (t.html(""), t.html(e));
            },
            updateNavigation: function () {
                var e,
                    t,
                    i = this;
                i.params.loop || ((e = (t = i.navigation).$nextEl), (t = t.$prevEl) && 0 < t.length && (i.isBeginning ? i.a11y.disableEl(t) : i.a11y.enableEl(t)), e && 0 < e.length && (i.isEnd ? i.a11y.disableEl(e) : i.a11y.enableEl(e)));
            },
            updatePagination: function () {
                var i = this,
                    n = i.params.a11y;
                i.pagination &&
                i.params.pagination.clickable &&
                i.pagination.bullets &&
                i.pagination.bullets.length &&
                i.pagination.bullets.each(function (e, t) {
                    t = x(t);
                    i.a11y.makeElFocusable(t), i.a11y.addElRole(t, "button"), i.a11y.addElLabel(t, n.paginationBulletMessage.replace(/{{index}}/, t.index() + 1));
                });
            },
            init: function () {
                var e = this;
                e.$el.append(e.a11y.liveRegion);
                var t,
                    i,
                    n = e.params.a11y;
                e.navigation && e.navigation.$nextEl && (t = e.navigation.$nextEl),
                e.navigation && e.navigation.$prevEl && (i = e.navigation.$prevEl),
                t && (e.a11y.makeElFocusable(t), e.a11y.addElRole(t, "button"), e.a11y.addElLabel(t, n.nextSlideMessage), t.on("keydown", e.a11y.onEnterKey)),
                i && (e.a11y.makeElFocusable(i), e.a11y.addElRole(i, "button"), e.a11y.addElLabel(i, n.prevSlideMessage), i.on("keydown", e.a11y.onEnterKey)),
                e.pagination && e.params.pagination.clickable && e.pagination.bullets && e.pagination.bullets.length && e.pagination.$el.on("keydown", "." + e.params.pagination.bulletClass, e.a11y.onEnterKey);
            },
            destroy: function () {
                var e,
                    t,
                    i = this;
                i.a11y.liveRegion && 0 < i.a11y.liveRegion.length && i.a11y.liveRegion.remove(),
                i.navigation && i.navigation.$nextEl && (e = i.navigation.$nextEl),
                i.navigation && i.navigation.$prevEl && (t = i.navigation.$prevEl),
                e && e.off("keydown", i.a11y.onEnterKey),
                t && t.off("keydown", i.a11y.onEnterKey),
                i.pagination && i.params.pagination.clickable && i.pagination.bullets && i.pagination.bullets.length && i.pagination.$el.off("keydown", "." + i.params.pagination.bulletClass, i.a11y.onEnterKey);
            },
        },
        U = {
            init: function () {
                var e = this;
                if (e.params.history) {
                    if (!c.history || !c.history.pushState) return (e.params.history.enabled = !1), void (e.params.hashNavigation.enabled = !0);
                    var t = e.history;
                    (t.initialized = !0),
                        (t.paths = U.getPathValues()),
                    (t.paths.key || t.paths.value) && (t.scrollToSlide(0, t.paths.value, e.params.runCallbacksOnInit), e.params.history.replaceState || c.addEventListener("popstate", e.history.setHistoryPopState));
                }
            },
            destroy: function () {
                this.params.history.replaceState || c.removeEventListener("popstate", this.history.setHistoryPopState);
            },
            setHistoryPopState: function () {
                (this.history.paths = U.getPathValues()), this.history.scrollToSlide(this.params.speed, this.history.paths.value, !1);
            },
            getPathValues: function () {
                var e = c.location.pathname
                        .slice(1)
                        .split("/")
                        .filter(function (e) {
                            return "" !== e;
                        }),
                    t = e.length;
                return { key: e[t - 2], value: e[t - 1] };
            },
            setHistory: function (e, t) {
                this.history.initialized &&
                this.params.history.enabled &&
                ((t = this.slides.eq(t)),
                    (t = U.slugify(t.attr("data-history"))),
                c.location.pathname.includes(e) || (t = e + "/" + t),
                ((e = c.history.state) && e.value === t) || (this.params.history.replaceState ? c.history.replaceState({ value: t }, null, t) : c.history.pushState({ value: t }, null, t)));
            },
            slugify: function (e) {
                return e
                    .toString()
                    .toLowerCase()
                    .replace(/\s+/g, "-")
                    .replace(/[^\w-]+/g, "")
                    .replace(/--+/g, "-")
                    .replace(/^-+/, "")
                    .replace(/-+$/, "");
            },
            scrollToSlide: function (e, t, i) {
                var n = this;
                if (t)
                    for (var s = 0, a = n.slides.length; s < a; s += 1) {
                        var o = n.slides.eq(s);
                        U.slugify(o.attr("data-history")) !== t || o.hasClass(n.params.slideDuplicateClass) || ((o = o.index()), n.slideTo(o, e, i));
                    }
                else n.slideTo(0, e, i);
            },
        },
        G = {
            onHashCange: function () {
                var e = this,
                    t = u.location.hash.replace("#", "");
                t !== e.slides.eq(e.activeIndex).attr("data-hash") && e.slideTo(e.$wrapperEl.children("." + e.params.slideClass + '[data-hash="' + t + '"]').index());
            },
            setHash: function () {
                var e = this;
                e.hashNavigation.initialized &&
                e.params.hashNavigation.enabled &&
                (e.params.hashNavigation.replaceState && c.history && c.history.replaceState
                    ? c.history.replaceState(null, null, "#" + e.slides.eq(e.activeIndex).attr("data-hash") || "")
                    : ((e = (e = e.slides.eq(e.activeIndex)).attr("data-hash") || e.attr("data-history")), (u.location.hash = e || "")));
            },
            init: function () {
                var e = this;
                if (!(!e.params.hashNavigation.enabled || (e.params.history && e.params.history.enabled))) {
                    e.hashNavigation.initialized = !0;
                    var t = u.location.hash.replace("#", "");
                    if (t)
                        for (var i = 0, n = e.slides.length; i < n; i += 1) {
                            var s = e.slides.eq(i);
                            (s.attr("data-hash") || s.attr("data-history")) !== t || s.hasClass(e.params.slideDuplicateClass) || ((s = s.index()), e.slideTo(s, 0, e.params.runCallbacksOnInit, !0));
                        }
                    e.params.hashNavigation.watchState && x(c).on("hashchange", e.hashNavigation.onHashCange);
                }
            },
            destroy: function () {
                this.params.hashNavigation.watchState && x(c).off("hashchange", this.hashNavigation.onHashCange);
            },
        },
        q = {
            run: function () {
                var e = this,
                    t = e.slides.eq(e.activeIndex),
                    i = e.params.autoplay.delay;
                t.attr("data-swiper-autoplay") && (i = t.attr("data-swiper-autoplay") || e.params.autoplay.delay),
                    (e.autoplay.timeout = P.nextTick(function () {
                        e.params.autoplay.reverseDirection
                            ? e.params.loop
                                ? (e.loopFix(), e.slidePrev(e.params.speed, !0, !0), e.emit("autoplay"))
                                : e.isBeginning
                                    ? e.params.autoplay.stopOnLastSlide
                                        ? e.autoplay.stop()
                                        : (e.slideTo(e.slides.length - 1, e.params.speed, !0, !0), e.emit("autoplay"))
                                    : (e.slidePrev(e.params.speed, !0, !0), e.emit("autoplay"))
                            : e.params.loop
                                ? (e.loopFix(), e.slideNext(e.params.speed, !0, !0), e.emit("autoplay"))
                                : e.isEnd
                                    ? e.params.autoplay.stopOnLastSlide
                                        ? e.autoplay.stop()
                                        : (e.slideTo(0, e.params.speed, !0, !0), e.emit("autoplay"))
                                    : (e.slideNext(e.params.speed, !0, !0), e.emit("autoplay"));
                    }, i));
            },
            start: function () {
                var e = this;
                return void 0 === e.autoplay.timeout && !e.autoplay.running && ((e.autoplay.running = !0), e.emit("autoplayStart"), e.autoplay.run(), !0);
            },
            stop: function () {
                var e = this;
                return !!e.autoplay.running && void 0 !== e.autoplay.timeout && (e.autoplay.timeout && (clearTimeout(e.autoplay.timeout), (e.autoplay.timeout = void 0)), (e.autoplay.running = !1), e.emit("autoplayStop"), !0);
            },
            pause: function (e) {
                var t = this;
                t.autoplay.running &&
                (t.autoplay.paused ||
                    (t.autoplay.timeout && clearTimeout(t.autoplay.timeout),
                        (t.autoplay.paused = !0),
                        0 !== e && t.params.autoplay.waitForTransition
                            ? t.$wrapperEl.transitionEnd(function () {
                                t && !t.destroyed && ((t.autoplay.paused = !1), t.autoplay.running ? t.autoplay.run() : t.autoplay.stop());
                            })
                            : ((t.autoplay.paused = !1), t.autoplay.run())));
            },
        },
        X = {
            setTranslate: function () {
                for (var e = this, t = e.slides, i = 0; i < t.length; i += 1) {
                    var n = e.slides.eq(i),
                        s = -n[0].swiperSlideOffset;
                    e.params.virtualTranslate || (s -= e.translate);
                    var a = 0;
                    e.isHorizontal() || ((a = s), (s = 0));
                    var o = e.params.fadeEffect.crossFade ? Math.max(1 - Math.abs(n[0].progress), 0) : 1 + Math.min(Math.max(n[0].progress, -1), 0);
                    n.css({ opacity: o }).transform("translate3d(" + s + "px, " + a + "px, 0px)");
                }
            },
            setTransition: function (e) {
                var i,
                    n = this,
                    t = n.slides,
                    s = n.$wrapperEl;
                t.transition(e),
                n.params.virtualTranslate &&
                0 !== e &&
                ((i = !1),
                    t.transitionEnd(function () {
                        if (!i && n && !n.destroyed) {
                            (i = !0), (n.animating = !1);
                            for (var e = ["webkitTransitionEnd", "transitionend"], t = 0; t < e.length; t += 1) s.trigger(e[t]);
                        }
                    }));
            },
        },
        Z = {
            setTranslate: function () {
                var e,
                    t = this,
                    i = t.$el,
                    n = t.$wrapperEl,
                    s = t.slides,
                    a = t.width,
                    o = t.height,
                    r = t.rtl,
                    l = t.size,
                    d = t.params.cubeEffect,
                    c = t.isHorizontal(),
                    u = t.virtual && t.params.virtual.enabled,
                    h = 0;
                d.shadow &&
                (c
                    ? (0 === (e = n.find(".swiper-cube-shadow")).length && ((e = x('<div class="swiper-cube-shadow"></div>')), n.append(e)), e.css({ height: a + "px" }))
                    : 0 === (e = i.find(".swiper-cube-shadow")).length && ((e = x('<div class="swiper-cube-shadow"></div>')), i.append(e)));
                for (var p = 0; p < s.length; p += 1) {
                    var f = s.eq(p),
                        m = p;
                    u && (m = parseInt(f.attr("data-swiper-slide-index"), 10));
                    var v = 90 * m,
                        g = Math.floor(v / 360);
                    r && ((v = -v), (g = Math.floor(-v / 360)));
                    var w = Math.max(Math.min(f[0].progress, 1), -1),
                        y = 0,
                        b = 0,
                        _ = 0;
                    m % 4 == 0 ? ((y = 4 * -g * l), (_ = 0)) : (m - 1) % 4 == 0 ? ((y = 0), (_ = 4 * -g * l)) : (m - 2) % 4 == 0 ? ((y = l + 4 * g * l), (_ = l)) : (m - 3) % 4 == 0 && ((y = -l), (_ = 3 * l + 4 * l * g)),
                    r && (y = -y),
                    c || ((b = y), (y = 0));
                    _ = "rotateX(" + (c ? 0 : -v) + "deg) rotateY(" + (c ? v : 0) + "deg) translate3d(" + y + "px, " + b + "px, " + _ + "px)";
                    w <= 1 && -1 < w && (h = r ? 90 * -m - 90 * w : 90 * m + 90 * w),
                        f.transform(_),
                    d.slideShadows &&
                    ((m = c ? f.find(".swiper-slide-shadow-left") : f.find(".swiper-slide-shadow-top")),
                        (_ = c ? f.find(".swiper-slide-shadow-right") : f.find(".swiper-slide-shadow-bottom")),
                    0 === m.length && ((m = x('<div class="swiper-slide-shadow-' + (c ? "left" : "top") + '"></div>')), f.append(m)),
                    0 === _.length && ((_ = x('<div class="swiper-slide-shadow-' + (c ? "right" : "bottom") + '"></div>')), f.append(_)),
                    m.length && (m[0].style.opacity = Math.max(-w, 0)),
                    _.length && (_[0].style.opacity = Math.max(w, 0)));
                }
                n.css({ "-webkit-transform-origin": "50% 50% -" + l / 2 + "px", "-moz-transform-origin": "50% 50% -" + l / 2 + "px", "-ms-transform-origin": "50% 50% -" + l / 2 + "px", "transform-origin": "50% 50% -" + l / 2 + "px" }),
                d.shadow &&
                (c
                    ? e.transform("translate3d(0px, " + (a / 2 + d.shadowOffset) + "px, " + -a / 2 + "px) rotateX(90deg) rotateZ(0deg) scale(" + d.shadowScale + ")")
                    : ((k = Math.abs(h) - 90 * Math.floor(Math.abs(h) / 90)),
                        (i = 1.5 - (Math.sin((2 * k * Math.PI) / 360) / 2 + Math.cos((2 * k * Math.PI) / 360) / 2)),
                        (a = d.shadowScale),
                        (k = d.shadowScale / i),
                        (i = d.shadowOffset),
                        e.transform("scale3d(" + a + ", 1, " + k + ") translate3d(0px, " + (o / 2 + i) + "px, " + -o / 2 / k + "px) rotateX(-90deg)")));
                var k = C.isSafari || C.isUiWebView ? -l / 2 : 0;
                n.transform("translate3d(0px,0," + k + "px) rotateX(" + (t.isHorizontal() ? 0 : h) + "deg) rotateY(" + (t.isHorizontal() ? -h : 0) + "deg)");
            },
            setTransition: function (e) {
                var t = this.$el;
                this.slides.transition(e).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(e),
                this.params.cubeEffect.shadow && !this.isHorizontal() && t.find(".swiper-cube-shadow").transition(e);
            },
        },
        K = {
            setTranslate: function () {
                for (var e = this, t = e.slides, i = 0; i < t.length; i += 1) {
                    var n = t.eq(i),
                        s = n[0].progress;
                    e.params.flipEffect.limitRotation && (s = Math.max(Math.min(n[0].progress, 1), -1));
                    var a,
                        o,
                        r = -180 * s,
                        l = 0,
                        d = -n[0].swiperSlideOffset,
                        c = 0;
                    e.isHorizontal() ? e.rtl && (r = -r) : ((c = d), (l = -r), (r = d = 0)),
                        (n[0].style.zIndex = -Math.abs(Math.round(s)) + t.length),
                    e.params.flipEffect.slideShadows &&
                    ((a = e.isHorizontal() ? n.find(".swiper-slide-shadow-left") : n.find(".swiper-slide-shadow-top")),
                        (o = e.isHorizontal() ? n.find(".swiper-slide-shadow-right") : n.find(".swiper-slide-shadow-bottom")),
                    0 === a.length && ((a = x('<div class="swiper-slide-shadow-' + (e.isHorizontal() ? "left" : "top") + '"></div>')), n.append(a)),
                    0 === o.length && ((o = x('<div class="swiper-slide-shadow-' + (e.isHorizontal() ? "right" : "bottom") + '"></div>')), n.append(o)),
                    a.length && (a[0].style.opacity = Math.max(-s, 0)),
                    o.length && (o[0].style.opacity = Math.max(s, 0))),
                        n.transform("translate3d(" + d + "px, " + c + "px, 0px) rotateX(" + l + "deg) rotateY(" + r + "deg)");
                }
            },
            setTransition: function (e) {
                var i,
                    n = this,
                    t = n.slides,
                    s = n.activeIndex,
                    a = n.$wrapperEl;
                t.transition(e).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(e),
                n.params.virtualTranslate &&
                0 !== e &&
                ((i = !1),
                    t.eq(s).transitionEnd(function () {
                        if (!i && n && !n.destroyed) {
                            (i = !0), (n.animating = !1);
                            for (var e = ["webkitTransitionEnd", "transitionend"], t = 0; t < e.length; t += 1) a.trigger(e[t]);
                        }
                    }));
            },
        },
        Q = {
            setTranslate: function () {
                for (
                    var e = this,
                        t = e.width,
                        i = e.height,
                        n = e.slides,
                        s = e.$wrapperEl,
                        a = e.slidesSizesGrid,
                        o = e.params.coverflowEffect,
                        r = e.isHorizontal(),
                        e = e.translate,
                        l = r ? t / 2 - e : i / 2 - e,
                        d = r ? o.rotate : -o.rotate,
                        c = o.depth,
                        u = 0,
                        h = n.length;
                    u < h;
                    u += 1
                ) {
                    var p = n.eq(u),
                        f = a[u],
                        m = ((l - p[0].swiperSlideOffset - f / 2) / f) * o.modifier,
                        v = r ? d * m : 0,
                        g = r ? 0 : d * m,
                        w = -c * Math.abs(m),
                        y = r ? 0 : o.stretch * m,
                        f = r ? o.stretch * m : 0;
                    Math.abs(f) < 0.001 && (f = 0), Math.abs(y) < 0.001 && (y = 0), Math.abs(w) < 0.001 && (w = 0), Math.abs(v) < 0.001 && (v = 0), Math.abs(g) < 0.001 && (g = 0);
                    g = "translate3d(" + f + "px," + y + "px," + w + "px)  rotateX(" + g + "deg) rotateY(" + v + "deg)";
                    p.transform(g),
                        (p[0].style.zIndex = 1 - Math.abs(Math.round(m))),
                    o.slideShadows &&
                    ((v = r ? p.find(".swiper-slide-shadow-left") : p.find(".swiper-slide-shadow-top")),
                        (g = r ? p.find(".swiper-slide-shadow-right") : p.find(".swiper-slide-shadow-bottom")),
                    0 === v.length && ((v = x('<div class="swiper-slide-shadow-' + (r ? "left" : "top") + '"></div>')), p.append(v)),
                    0 === g.length && ((g = x('<div class="swiper-slide-shadow-' + (r ? "right" : "bottom") + '"></div>')), p.append(g)),
                    v.length && (v[0].style.opacity = 0 < m ? m : 0),
                    g.length && (g[0].style.opacity = 0 < -m ? -m : 0));
                }
                (A.pointerEvents || A.prefixedPointerEvents) && (s[0].style.perspectiveOrigin = l + "px 50%");
            },
            setTransition: function (e) {
                this.slides.transition(e).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(e);
            },
        },
        s = [
            v,
            g,
            w,
            y,
            t,
            k,
            s,
            {
                name: "mousewheel",
                params: { mousewheel: { enabled: !1, releaseOnEdges: !1, invert: !1, forceToAxis: !1, sensitivity: 1, eventsTarged: "container" } },
                create: function () {
                    P.extend(this, { mousewheel: { enabled: !1, enable: W.enable.bind(this), disable: W.disable.bind(this), handle: W.handle.bind(this), lastScrollTime: P.now() } });
                },
                on: {
                    init: function () {
                        this.params.mousewheel.enabled && this.mousewheel.enable();
                    },
                    destroy: function () {
                        this.mousewheel.enabled && this.mousewheel.disable();
                    },
                },
            },
            {
                name: "navigation",
                params: { navigation: { nextEl: null, prevEl: null, hideOnClick: !1, disabledClass: "swiper-button-disabled", hiddenClass: "swiper-button-hidden", lockClass: "swiper-button-lock" } },
                create: function () {
                    P.extend(this, { navigation: { init: N.init.bind(this), update: N.update.bind(this), destroy: N.destroy.bind(this) } });
                },
                on: {
                    init: function () {
                        this.navigation.init(), this.navigation.update();
                    },
                    toEdge: function () {
                        this.navigation.update();
                    },
                    fromEdge: function () {
                        this.navigation.update();
                    },
                    destroy: function () {
                        this.navigation.destroy();
                    },
                    click: function (e) {
                        var t = this.navigation,
                            i = t.$nextEl,
                            t = t.$prevEl;
                        !this.params.navigation.hideOnClick || x(e.target).is(t) || x(e.target).is(i) || (i && i.toggleClass(this.params.navigation.hiddenClass), t && t.toggleClass(this.params.navigation.hiddenClass));
                    },
                },
            },
            {
                name: "pagination",
                params: {
                    pagination: {
                        el: null,
                        bulletElement: "span",
                        clickable: !1,
                        hideOnClick: !1,
                        renderBullet: null,
                        renderProgressbar: null,
                        renderFraction: null,
                        renderCustom: null,
                        type: "bullets",
                        dynamicBullets: !1,
                        dynamicMainBullets: 1,
                        bulletClass: "swiper-pagination-bullet",
                        bulletActiveClass: "swiper-pagination-bullet-active",
                        modifierClass: "swiper-pagination-",
                        currentClass: "swiper-pagination-current",
                        totalClass: "swiper-pagination-total",
                        hiddenClass: "swiper-pagination-hidden",
                        progressbarFillClass: "swiper-pagination-progressbar-fill",
                        clickableClass: "swiper-pagination-clickable",
                        lockClass: "swiper-pagination-lock",
                    },
                },
                create: function () {
                    var e = this;
                    P.extend(e, { pagination: { init: Y.init.bind(e), render: Y.render.bind(e), update: Y.update.bind(e), destroy: Y.destroy.bind(e), dynamicBulletIndex: 0 } });
                },
                on: {
                    init: function () {
                        this.pagination.init(), this.pagination.render(), this.pagination.update();
                    },
                    activeIndexChange: function () {
                        (!this.params.loop && void 0 !== this.snapIndex) || this.pagination.update();
                    },
                    snapIndexChange: function () {
                        this.params.loop || this.pagination.update();
                    },
                    slidesLengthChange: function () {
                        this.params.loop && (this.pagination.render(), this.pagination.update());
                    },
                    snapGridLengthChange: function () {
                        this.params.loop || (this.pagination.render(), this.pagination.update());
                    },
                    destroy: function () {
                        this.pagination.destroy();
                    },
                    click: function (e) {
                        var t = this;
                        t.params.pagination.el && t.params.pagination.hideOnClick && 0 < t.pagination.$el.length && !x(e.target).hasClass(t.params.pagination.bulletClass) && t.pagination.$el.toggleClass(t.params.pagination.hiddenClass);
                    },
                },
            },
            {
                name: "scrollbar",
                params: { scrollbar: { el: null, dragSize: "auto", hide: !1, draggable: !1, snapOnRelease: !0, lockClass: "swiper-scrollbar-lock", dragClass: "swiper-scrollbar-drag" } },
                create: function () {
                    var e = this;
                    P.extend(e, {
                        scrollbar: {
                            init: j.init.bind(e),
                            destroy: j.destroy.bind(e),
                            updateSize: j.updateSize.bind(e),
                            setTranslate: j.setTranslate.bind(e),
                            setTransition: j.setTransition.bind(e),
                            enableDraggable: j.enableDraggable.bind(e),
                            disableDraggable: j.disableDraggable.bind(e),
                            setDragPosition: j.setDragPosition.bind(e),
                            onDragStart: j.onDragStart.bind(e),
                            onDragMove: j.onDragMove.bind(e),
                            onDragEnd: j.onDragEnd.bind(e),
                            isTouched: !1,
                            timeout: null,
                            dragTimeout: null,
                        },
                    });
                },
                on: {
                    init: function () {
                        this.scrollbar.init(), this.scrollbar.updateSize(), this.scrollbar.setTranslate();
                    },
                    update: function () {
                        this.scrollbar.updateSize();
                    },
                    resize: function () {
                        this.scrollbar.updateSize();
                    },
                    observerUpdate: function () {
                        this.scrollbar.updateSize();
                    },
                    setTranslate: function () {
                        this.scrollbar.setTranslate();
                    },
                    setTransition: function (e) {
                        this.scrollbar.setTransition(e);
                    },
                    destroy: function () {
                        this.scrollbar.destroy();
                    },
                },
            },
            {
                name: "parallax",
                params: { parallax: { enabled: !1 } },
                create: function () {
                    P.extend(this, { parallax: { setTransform: H.setTransform.bind(this), setTranslate: H.setTranslate.bind(this), setTransition: H.setTransition.bind(this) } });
                },
                on: {
                    beforeInit: function () {
                        this.params.parallax.enabled && (this.params.watchSlidesProgress = !0);
                    },
                    init: function () {
                        this.params.parallax && this.parallax.setTranslate();
                    },
                    setTranslate: function () {
                        this.params.parallax && this.parallax.setTranslate();
                    },
                    setTransition: function (e) {
                        this.params.parallax && this.parallax.setTransition(e);
                    },
                },
            },
            {
                name: "zoom",
                params: { zoom: { enabled: !1, maxRatio: 3, minRatio: 1, toggle: !0, containerClass: "swiper-zoom-container", zoomedSlideClass: "swiper-slide-zoomed" } },
                create: function () {
                    var t = this,
                        i = {
                            enabled: !1,
                            scale: 1,
                            currentScale: 1,
                            isScaling: !1,
                            gesture: { $slideEl: void 0, slideWidth: void 0, slideHeight: void 0, $imageEl: void 0, $imageWrapEl: void 0, maxRatio: 3 },
                            image: {
                                isTouched: void 0,
                                isMoved: void 0,
                                currentX: void 0,
                                currentY: void 0,
                                minX: void 0,
                                minY: void 0,
                                maxX: void 0,
                                maxY: void 0,
                                width: void 0,
                                height: void 0,
                                startX: void 0,
                                startY: void 0,
                                touchesStart: {},
                                touchesCurrent: {},
                            },
                            velocity: { x: void 0, y: void 0, prevPositionX: void 0, prevPositionY: void 0, prevTime: void 0 },
                        };
                    "onGestureStart onGestureChange onGestureEnd onTouchStart onTouchMove onTouchEnd onTransitionEnd toggle enable disable in out".split(" ").forEach(function (e) {
                        i[e] = R[e].bind(t);
                    }),
                        P.extend(t, { zoom: i });
                },
                on: {
                    init: function () {
                        this.params.zoom.enabled && this.zoom.enable();
                    },
                    destroy: function () {
                        this.zoom.disable();
                    },
                    touchStart: function (e) {
                        this.zoom.enabled && this.zoom.onTouchStart(e);
                    },
                    touchEnd: function (e) {
                        this.zoom.enabled && this.zoom.onTouchEnd(e);
                    },
                    doubleTap: function (e) {
                        this.params.zoom.enabled && this.zoom.enabled && this.params.zoom.toggle && this.zoom.toggle(e);
                    },
                    transitionEnd: function () {
                        this.zoom.enabled && this.params.zoom.enabled && this.zoom.onTransitionEnd();
                    },
                },
            },
            {
                name: "lazy",
                params: {
                    lazy: {
                        enabled: !1,
                        loadPrevNext: !1,
                        loadPrevNextAmount: 1,
                        loadOnTransitionStart: !1,
                        elementClass: "swiper-lazy",
                        loadingClass: "swiper-lazy-loading",
                        loadedClass: "swiper-lazy-loaded",
                        preloaderClass: "swiper-lazy-preloader",
                    },
                },
                create: function () {
                    P.extend(this, { lazy: { initialImageLoaded: !1, load: F.load.bind(this), loadInSlide: F.loadInSlide.bind(this) } });
                },
                on: {
                    beforeInit: function () {
                        this.params.lazy.enabled && this.params.preloadImages && (this.params.preloadImages = !1);
                    },
                    init: function () {
                        this.params.lazy.enabled && !this.params.loop && 0 === this.params.initialSlide && this.lazy.load();
                    },
                    scroll: function () {
                        this.params.freeMode && !this.params.freeModeSticky && this.lazy.load();
                    },
                    resize: function () {
                        this.params.lazy.enabled && this.lazy.load();
                    },
                    scrollbarDragMove: function () {
                        this.params.lazy.enabled && this.lazy.load();
                    },
                    transitionStart: function () {
                        var e = this;
                        e.params.lazy.enabled && ((!e.params.lazy.loadOnTransitionStart && (e.params.lazy.loadOnTransitionStart || e.lazy.initialImageLoaded)) || e.lazy.load());
                    },
                    transitionEnd: function () {
                        this.params.lazy.enabled && !this.params.lazy.loadOnTransitionStart && this.lazy.load();
                    },
                },
            },
            {
                name: "controller",
                params: { controller: { control: void 0, inverse: !1, by: "slide" } },
                create: function () {
                    var e = this;
                    P.extend(e, { controller: { control: e.params.controller.control, getInterpolateFunction: B.getInterpolateFunction.bind(e), setTranslate: B.setTranslate.bind(e), setTransition: B.setTransition.bind(e) } });
                },
                on: {
                    update: function () {
                        this.controller.control && this.controller.spline && ((this.controller.spline = void 0), delete this.controller.spline);
                    },
                    resize: function () {
                        this.controller.control && this.controller.spline && ((this.controller.spline = void 0), delete this.controller.spline);
                    },
                    observerUpdate: function () {
                        this.controller.control && this.controller.spline && ((this.controller.spline = void 0), delete this.controller.spline);
                    },
                    setTranslate: function (e, t) {
                        this.controller.control && this.controller.setTranslate(e, t);
                    },
                    setTransition: function (e, t) {
                        this.controller.control && this.controller.setTransition(e, t);
                    },
                },
            },
            {
                name: "a11y",
                params: {
                    a11y: {
                        enabled: !1,
                        notificationClass: "swiper-notification",
                        prevSlideMessage: "Previous slide",
                        nextSlideMessage: "Next slide",
                        firstSlideMessage: "This is the first slide",
                        lastSlideMessage: "This is the last slide",
                        paginationBulletMessage: "Go to slide {{index}}",
                    },
                },
                create: function () {
                    var t = this;
                    P.extend(t, { a11y: { liveRegion: x('<span class="' + t.params.a11y.notificationClass + '" aria-live="assertive" aria-atomic="true"></span>') } }),
                        Object.keys(V).forEach(function (e) {
                            t.a11y[e] = V[e].bind(t);
                        });
                },
                on: {
                    init: function () {
                        this.params.a11y.enabled && (this.a11y.init(), this.a11y.updateNavigation());
                    },
                    toEdge: function () {
                        this.params.a11y.enabled && this.a11y.updateNavigation();
                    },
                    fromEdge: function () {
                        this.params.a11y.enabled && this.a11y.updateNavigation();
                    },
                    paginationUpdate: function () {
                        this.params.a11y.enabled && this.a11y.updatePagination();
                    },
                    destroy: function () {
                        this.params.a11y.enabled && this.a11y.destroy();
                    },
                },
            },
            {
                name: "history",
                params: { history: { enabled: !1, replaceState: !1, key: "slides" } },
                create: function () {
                    var e = this;
                    P.extend(e, { history: { init: U.init.bind(e), setHistory: U.setHistory.bind(e), setHistoryPopState: U.setHistoryPopState.bind(e), scrollToSlide: U.scrollToSlide.bind(e), destroy: U.destroy.bind(e) } });
                },
                on: {
                    init: function () {
                        this.params.history.enabled && this.history.init();
                    },
                    destroy: function () {
                        this.params.history.enabled && this.history.destroy();
                    },
                    transitionEnd: function () {
                        this.history.initialized && this.history.setHistory(this.params.history.key, this.activeIndex);
                    },
                },
            },
            {
                name: "hash-navigation",
                params: { hashNavigation: { enabled: !1, replaceState: !1, watchState: !1 } },
                create: function () {
                    var e = this;
                    P.extend(e, { hashNavigation: { initialized: !1, init: G.init.bind(e), destroy: G.destroy.bind(e), setHash: G.setHash.bind(e), onHashCange: G.onHashCange.bind(e) } });
                },
                on: {
                    init: function () {
                        this.params.hashNavigation.enabled && this.hashNavigation.init();
                    },
                    destroy: function () {
                        this.params.hashNavigation.enabled && this.hashNavigation.destroy();
                    },
                    transitionEnd: function () {
                        this.hashNavigation.initialized && this.hashNavigation.setHash();
                    },
                },
            },
            {
                name: "autoplay",
                params: { autoplay: { enabled: !1, delay: 3e3, waitForTransition: !0, disableOnInteraction: !0, stopOnLastSlide: !1, reverseDirection: !1 } },
                create: function () {
                    var e = this;
                    P.extend(e, { autoplay: { running: !1, paused: !1, run: q.run.bind(e), start: q.start.bind(e), stop: q.stop.bind(e), pause: q.pause.bind(e) } });
                },
                on: {
                    init: function () {
                        this.params.autoplay.enabled && this.autoplay.start();
                    },
                    beforeTransitionStart: function (e, t) {
                        this.autoplay.running && (t || !this.params.autoplay.disableOnInteraction ? this.autoplay.pause(e) : this.autoplay.stop());
                    },
                    sliderFirstMove: function () {
                        this.autoplay.running && (this.params.autoplay.disableOnInteraction ? this.autoplay.stop() : this.autoplay.pause());
                    },
                    destroy: function () {
                        this.autoplay.running && this.autoplay.stop();
                    },
                },
            },
            {
                name: "effect-fade",
                params: { fadeEffect: { crossFade: !1 } },
                create: function () {
                    P.extend(this, { fadeEffect: { setTranslate: X.setTranslate.bind(this), setTransition: X.setTransition.bind(this) } });
                },
                on: {
                    beforeInit: function () {
                        var e,
                            t = this;
                        "fade" === t.params.effect &&
                        (t.classNames.push(t.params.containerModifierClass + "fade"),
                            (e = { slidesPerView: 1, slidesPerColumn: 1, slidesPerGroup: 1, watchSlidesProgress: !0, spaceBetween: 0, virtualTranslate: !0 }),
                            P.extend(t.params, e),
                            P.extend(t.originalParams, e));
                    },
                    setTranslate: function () {
                        "fade" === this.params.effect && this.fadeEffect.setTranslate();
                    },
                    setTransition: function (e) {
                        "fade" === this.params.effect && this.fadeEffect.setTransition(e);
                    },
                },
            },
            {
                name: "effect-cube",
                params: { cubeEffect: { slideShadows: !0, shadow: !0, shadowOffset: 20, shadowScale: 0.94 } },
                create: function () {
                    P.extend(this, { cubeEffect: { setTranslate: Z.setTranslate.bind(this), setTransition: Z.setTransition.bind(this) } });
                },
                on: {
                    beforeInit: function () {
                        var e,
                            t = this;
                        "cube" === t.params.effect &&
                        (t.classNames.push(t.params.containerModifierClass + "cube"),
                            t.classNames.push(t.params.containerModifierClass + "3d"),
                            (e = { slidesPerView: 1, slidesPerColumn: 1, slidesPerGroup: 1, watchSlidesProgress: !0, resistanceRatio: 0, spaceBetween: 0, centeredSlides: !1, virtualTranslate: !0 }),
                            P.extend(t.params, e),
                            P.extend(t.originalParams, e));
                    },
                    setTranslate: function () {
                        "cube" === this.params.effect && this.cubeEffect.setTranslate();
                    },
                    setTransition: function (e) {
                        "cube" === this.params.effect && this.cubeEffect.setTransition(e);
                    },
                },
            },
            {
                name: "effect-flip",
                params: { flipEffect: { slideShadows: !0, limitRotation: !0 } },
                create: function () {
                    P.extend(this, { flipEffect: { setTranslate: K.setTranslate.bind(this), setTransition: K.setTransition.bind(this) } });
                },
                on: {
                    beforeInit: function () {
                        var e,
                            t = this;
                        "flip" === t.params.effect &&
                        (t.classNames.push(t.params.containerModifierClass + "flip"),
                            t.classNames.push(t.params.containerModifierClass + "3d"),
                            (e = { slidesPerView: 1, slidesPerColumn: 1, slidesPerGroup: 1, watchSlidesProgress: !0, spaceBetween: 0, virtualTranslate: !0 }),
                            P.extend(t.params, e),
                            P.extend(t.originalParams, e));
                    },
                    setTranslate: function () {
                        "flip" === this.params.effect && this.flipEffect.setTranslate();
                    },
                    setTransition: function (e) {
                        "flip" === this.params.effect && this.flipEffect.setTransition(e);
                    },
                },
            },
            {
                name: "effect-coverflow",
                params: { coverflowEffect: { rotate: 50, stretch: 0, depth: 100, modifier: 1, slideShadows: !0 } },
                create: function () {
                    P.extend(this, { coverflowEffect: { setTranslate: Q.setTranslate.bind(this), setTransition: Q.setTransition.bind(this) } });
                },
                on: {
                    beforeInit: function () {
                        var e = this;
                        "coverflow" === e.params.effect &&
                        (e.classNames.push(e.params.containerModifierClass + "coverflow"), e.classNames.push(e.params.containerModifierClass + "3d"), (e.params.watchSlidesProgress = !0), (e.originalParams.watchSlidesProgress = !0));
                    },
                    setTranslate: function () {
                        "coverflow" === this.params.effect && this.coverflowEffect.setTranslate();
                    },
                    setTransition: function (e) {
                        "coverflow" === this.params.effect && this.coverflowEffect.setTransition(e);
                    },
                },
            },
        ];
    return void 0 === E.use && ((E.use = E.Class.use), (E.installModule = E.Class.installModule)), E.use(s), E;
}),
    (function (e) {
        "function" == typeof define && define.amd ? define("picker", ["jquery"], e) : "object" == typeof exports ? (module.exports = e(require("jquery"))) : (this.Picker = e(jQuery));
    })(function (f) {
        var n = f(window),
            m = f(document),
            s = f(document.documentElement),
            v = null != document.documentElement.style.transition;
        function g(s, t, i, e) {
            if (!s) return g;
            var n = !1,
                r = { id: s.id || "P" + Math.abs(~~(Math.random() * new Date())) },
                l = i ? f.extend(!0, {}, i.defaults, e) : e || {},
                a = f.extend({}, g.klasses(), l.klass),
                d = f(s),
                e = function () {
                    return this.start();
                },
                c = (e.prototype = {
                    constructor: e,
                    $node: d,
                    start: function () {
                        return r && r.start
                            ? c
                            : ((r.methods = {}),
                                (r.start = !0),
                                (r.open = !1),
                                (r.type = s.type),
                                (s.autofocus = s == _()),
                                (s.readOnly = !l.editable),
                                (s.id = s.id || r.id),
                            "text" != s.type && (s.type = "text"),
                                (c.component = new i(c, l)),
                                (c.$root = f('<div class="' + a.picker + '" id="' + s.id + '_root" />')),
                                b(c.$root[0], "hidden", !0),
                                (c.$holder = f(o()).appendTo(c.$root)),
                                u(),
                            l.formatSubmit &&
                            (!0 === l.hiddenName
                                ? ((e = s.name), (s.name = ""))
                                : (e = (e = ["string" == typeof l.hiddenPrefix ? l.hiddenPrefix : "", "string" == typeof l.hiddenSuffix ? l.hiddenSuffix : "_submit"])[0] + s.name + e[1]),
                                (c._hidden = f('<input type=hidden name="' + e + '"' + (d.data("value") || s.value ? ' value="' + c.get("select", l.formatSubmit) + '"' : "") + ">")[0]),
                                d.on("change." + r.id, function () {
                                    c._hidden.value = s.value ? c.get("select", l.formatSubmit) : "";
                                })),
                                d
                                    .data(t, c)
                                    .addClass(a.input)
                                    .val(d.data("value") ? c.get("select", l.format) : s.value)
                                    .on("focus." + r.id + " click." + r.id, function (e) {
                                        e.preventDefault(), c.open();
                                    }),
                            l.editable || d.on("keydown." + r.id, p),
                                b(s, { haspopup: !0, expanded: !1, readonly: !1, owns: s.id + "_root" }),
                                l.containerHidden ? f(l.containerHidden).append(c._hidden) : d.after(c._hidden),
                                l.container ? f(l.container).append(c.$root) : d.after(c.$root),
                                c
                                    .on({ start: c.component.onStart, render: c.component.onRender, stop: c.component.onStop, open: c.component.onOpen, close: c.component.onClose, set: c.component.onSet })
                                    .on({ start: l.onStart, render: l.onRender, stop: l.onStop, open: l.onOpen, close: l.onClose, set: l.onSet }),
                                (n = (function (e) {
                                    var t,
                                        i = "position";
                                    e.currentStyle ? (t = e.currentStyle[i]) : window.getComputedStyle && (t = getComputedStyle(e)[i]);
                                    return "fixed" == t;
                                })(c.$holder[0])),
                            s.autofocus && c.open(),
                                c.trigger("start").trigger("render"));
                        var e;
                    },
                    render: function (e) {
                        return e ? ((c.$holder = f(o())), u(), c.$root.html(c.$holder)) : c.$root.find("." + a.box).html(c.component.nodes(r.open)), c.trigger("render");
                    },
                    stop: function () {
                        return (
                            r.start &&
                            (c.close(),
                            c._hidden && c._hidden.parentNode.removeChild(c._hidden),
                                c.$root.remove(),
                                d.removeClass(a.input).removeData(t),
                                setTimeout(function () {
                                    d.off("." + r.id);
                                }, 0),
                                (s.type = r.type),
                                (s.readOnly = !1),
                                c.trigger("stop"),
                                (r.methods = {}),
                                (r.start = !1)),
                                c
                        );
                    },
                    open: function (e) {
                        return r.open
                            ? c
                            : (d.addClass(a.active),
                                b(s, "expanded", !0),
                                setTimeout(function () {
                                    c.$root.addClass(a.opened), b(c.$root[0], "hidden", !1);
                                }, 0),
                            !1 !== e &&
                            ((r.open = !0),
                            n &&
                            f("body")
                                .css("overflow", "hidden")
                                .css("padding-right", "+=" + w()),
                                n && v
                                    ? c.$holder.find("." + a.frame).one("transitionend", function () {
                                        c.$holder.eq(0).focus();
                                    })
                                    : setTimeout(function () {
                                        c.$holder.eq(0).focus();
                                    }, 0),
                                m
                                    .on("click." + r.id + " focusin." + r.id, function (e) {
                                        var t = y(e, s);
                                        e.isSimulated || t == s || t == document || 3 == e.which || c.close(t === c.$holder[0]);
                                    })
                                    .on("keydown." + r.id, function (e) {
                                        var t = e.keyCode,
                                            i = c.component.key[t],
                                            n = y(e, s);
                                        27 == t
                                            ? c.close(!0)
                                            : n != c.$holder[0] || (!i && 13 != t)
                                                ? f.contains(c.$root[0], n) && 13 == t && (e.preventDefault(), n.click())
                                                : (e.preventDefault(),
                                                    i
                                                        ? g._.trigger(c.component.key.go, c, [g._.trigger(i)])
                                                        : c.$root.find("." + a.highlighted).hasClass(a.disabled) || (c.set("select", c.component.item.highlight), l.closeOnSelect && c.close(!0)));
                                    })),
                                c.trigger("open"));
                    },
                    close: function (e) {
                        return (
                            e &&
                            (l.editable
                                ? s.focus()
                                : (c.$holder.off("focus.toOpen").focus(),
                                    setTimeout(function () {
                                        c.$holder.on("focus.toOpen", h);
                                    }, 0))),
                                d.removeClass(a.active),
                                b(s, "expanded", !1),
                                setTimeout(function () {
                                    c.$root.removeClass(a.opened + " " + a.focused), b(c.$root[0], "hidden", !0);
                                }, 0),
                                r.open
                                    ? ((r.open = !1),
                                    n &&
                                    f("body")
                                        .css("overflow", "")
                                        .css("padding-right", "-=" + w()),
                                        m.off("." + r.id),
                                        c.trigger("close"))
                                    : c
                        );
                    },
                    clear: function (e) {
                        return c.set("clear", null, e);
                    },
                    set: function (e, t, i) {
                        var n,
                            s,
                            a = f.isPlainObject(e),
                            o = a ? e : {};
                        if (((i = a && f.isPlainObject(t) ? t : i || {}), e)) {
                            for (n in (a || (o[e] = t), o))
                                (s = o[n]),
                                n in c.component.item && (void 0 === s && (s = null), c.component.set(n, s, i)),
                                ("select" != n && "clear" != n) || !l.updateInput || d.val("clear" == n ? "" : c.get(n, l.format)).trigger("change");
                            c.render();
                        }
                        return i.muted ? c : c.trigger("set", o);
                    },
                    get: function (e, t) {
                        if (null != r[(e = e || "value")]) return r[e];
                        if ("valueSubmit" == e) {
                            if (c._hidden) return c._hidden.value;
                            e = "value";
                        }
                        if ("value" == e) return s.value;
                        if (e in c.component.item) {
                            if ("string" != typeof t) return c.component.get(e);
                            e = c.component.get(e);
                            return e ? g._.trigger(c.component.formats.toString, c.component, [t, e]) : "";
                        }
                    },
                    on: function (e, t, i) {
                        var n,
                            s,
                            a = f.isPlainObject(e),
                            o = a ? e : {};
                        if (e) for (n in (a || (o[e] = t), o)) (s = o[n]), i && (n = "_" + n), (r.methods[n] = r.methods[n] || []), r.methods[n].push(s);
                        return c;
                    },
                    off: function () {
                        var e,
                            t = arguments,
                            i = 0;
                        for (namesCount = t.length; i < namesCount; i += 1) (e = t[i]) in r.methods && delete r.methods[e];
                        return c;
                    },
                    trigger: function (e, t) {
                        function i(e) {
                            (e = r.methods[e]) &&
                            e.map(function (e) {
                                g._.trigger(e, c, [t]);
                            });
                        }
                        return i("_" + e), i(e), c;
                    },
                });
            function o() {
                return g._.node("div", g._.node("div", g._.node("div", g._.node("div", c.component.nodes(r.open), a.box), a.wrap), a.frame), a.holder, 'tabindex="-1"');
            }
            function u() {
                c.$holder
                    .on({
                        keydown: p,
                        "focus.toOpen": h,
                        blur: function () {
                            d.removeClass(a.target);
                        },
                        focusin: function (e) {
                            c.$root.removeClass(a.focused), e.stopPropagation();
                        },
                        "mousedown click": function (e) {
                            var t = y(e, s);
                            t != c.$holder[0] && (e.stopPropagation(), "mousedown" != e.type || f(t).is("input, select, textarea, button, option") || (e.preventDefault(), c.$holder.eq(0).focus()));
                        },
                    })
                    .on("click", "[data-pick], [data-nav], [data-clear], [data-close]", function () {
                        var e = f(this),
                            t = e.data(),
                            i = e.hasClass(a.navDisabled) || e.hasClass(a.disabled),
                            e = (e = _()) && (e.type || e.href ? e : null);
                        (i || (e && !f.contains(c.$root[0], e))) && c.$holder.eq(0).focus(),
                            !i && t.nav
                                ? c.set("highlight", c.component.item.highlight, { nav: t.nav })
                                : !i && "pick" in t
                                    ? (c.set("select", t.pick), l.closeOnSelect && c.close(!0))
                                    : t.clear
                                        ? (c.clear(), l.closeOnClear && c.close(!0))
                                        : t.close && c.close(!0);
                    });
            }
            function h(e) {
                e.stopPropagation(), d.addClass(a.target), c.$root.addClass(a.focused), c.open();
            }
            function p(e) {
                var t = e.keyCode,
                    i = /^(8|46)$/.test(t);
                if (27 == t) return c.close(!0), !1;
                (32 == t || i || (!r.open && c.component.key[t])) && (e.preventDefault(), e.stopPropagation(), i ? c.clear().close() : c.open());
            }
            return new e();
        }
        function w() {
            if (s.height() <= n.height()) return 0;
            var e = f('<div style="visibility:hidden;width:100px" />').appendTo("body"),
                t = e[0].offsetWidth;
            e.css("overflow", "scroll");
            var i = f('<div style="width:100%" />').appendTo(e)[0].offsetWidth;
            return e.remove(), t - i;
        }
        function y(e, t) {
            var i = [];
            return e.path && (i = e.path), e.originalEvent && e.originalEvent.path && (i = e.originalEvent.path), i && 0 < i.length ? (t && 0 <= i.indexOf(t) ? t : i[0]) : e.target;
        }
        function b(e, t, i) {
            if (f.isPlainObject(t)) for (var n in t) a(e, n, t[n]);
            else a(e, t, i);
        }
        function a(e, t, i) {
            e.setAttribute(("role" == t ? "" : "aria-") + t, i);
        }
        function _() {
            try {
                return document.activeElement;
            } catch (e) {}
        }
        return (
            (g.klasses = function (e) {
                return {
                    picker: (e = e || "picker"),
                    opened: e + "--opened",
                    focused: e + "--focused",
                    input: e + "__input",
                    active: e + "__input--active",
                    target: e + "__input--target",
                    holder: e + "__holder",
                    frame: e + "__frame",
                    wrap: e + "__wrap",
                    box: e + "__box",
                };
            }),
                (g._ = {
                    group: function (e) {
                        for (var t, i = "", n = g._.trigger(e.min, e); n <= g._.trigger(e.max, e, [n]); n += e.i) (t = g._.trigger(e.item, e, [n])), (i += g._.node(e.node, t[0], t[1], t[2]));
                        return i;
                    },
                    node: function (e, t, i, n) {
                        return t ? "<" + e + (i = i ? ' class="' + i + '"' : "") + (n = n ? " " + n : "") + ">" + (t = f.isArray(t) ? t.join("") : t) + "</" + e + ">" : "";
                    },
                    lead: function (e) {
                        return (e < 10 ? "0" : "") + e;
                    },
                    trigger: function (e, t, i) {
                        return "function" == typeof e ? e.apply(t, i || []) : e;
                    },
                    digits: function (e) {
                        return /\d/.test(e[1]) ? 2 : 1;
                    },
                    isDate: function (e) {
                        return -1 < {}.toString.call(e).indexOf("Date") && this.isInteger(e.getDate());
                    },
                    isInteger: function (e) {
                        return -1 < {}.toString.call(e).indexOf("Number") && e % 1 == 0;
                    },
                    ariaAttr: function (e, t) {
                        f.isPlainObject(e) || (e = { attribute: t });
                        for (var i in ((t = ""), e)) {
                            var n = ("role" == i ? "" : "aria-") + i,
                                s = e[i];
                            t += null == s ? "" : n + '="' + e[i] + '"';
                        }
                        return t;
                    },
                }),
                (g.extend = function (n, s) {
                    (f.fn[n] = function (e, t) {
                        var i = this.data(n);
                        return "picker" == e
                            ? i
                            : i && "string" == typeof e
                                ? g._.trigger(i[e], i, [t])
                                : this.each(function () {
                                    f(this).data(n) || new g(this, n, s, e);
                                });
                    }),
                        (f.fn[n].defaults = s.defaults);
                }),
                g
        );
    }),
    (function (e) {
        "function" == typeof define && define.amd ? define(["./picker", "jquery"], e) : "object" == typeof exports ? (module.exports = e(require("./picker.js"), require("jquery"))) : e(Picker, jQuery);
    })(function (e, f) {
        var t,
            v = e._;
        function i(t, i) {
            function e() {
                return s.currentStyle ? "rtl" == s.currentStyle.direction : "rtl" == getComputedStyle(t.$root[0]).direction;
            }
            var n = this,
                s = t.$node[0],
                a = s.value,
                o = t.$node.data("value"),
                r = o || a,
                a = o ? i.formatSubmit : i.format;
            (n.settings = i),
                (n.$node = t.$node),
                (n.queue = {
                    min: "measure create",
                    max: "measure create",
                    now: "now create",
                    select: "parse create validate",
                    highlight: "parse navigate create validate",
                    view: "parse create validate viewset",
                    disable: "deactivate",
                    enable: "activate",
                }),
                (n.item = {}),
                (n.item.clear = null),
                (n.item.disable = (i.disable || []).slice(0)),
                (n.item.enable = -(!0 === (o = n.item.disable)[0] ? o.shift() : -1)),
                n.set("min", i.min).set("max", i.max).set("now"),
                r ? n.set("select", r, { format: a, defaultValue: !0 }) : n.set("select", null).set("highlight", n.item.now),
                (n.key = {
                    40: 7,
                    38: -7,
                    39: function () {
                        return e() ? -1 : 1;
                    },
                    37: function () {
                        return e() ? 1 : -1;
                    },
                    go: function (e) {
                        var t = n.item.highlight,
                            t = new Date(t.year, t.month, t.date + e);
                        n.set("highlight", t, { interval: e }), this.render();
                    },
                }),
                t
                    .on(
                        "render",
                        function () {
                            t.$root.find("." + i.klass.selectMonth).on("change", function () {
                                var e = this.value;
                                e && (t.set("highlight", [t.get("view").year, e, t.get("highlight").date]), t.$root.find("." + i.klass.selectMonth).trigger("focus"));
                            }),
                                t.$root.find("." + i.klass.selectYear).on("change", function () {
                                    var e = this.value;
                                    e && (t.set("highlight", [e, t.get("view").month, t.get("highlight").date]), t.$root.find("." + i.klass.selectYear).trigger("focus"));
                                });
                        },
                        1
                    )
                    .on(
                        "open",
                        function () {
                            var e = "";
                            n.disabled(n.get("now")) && (e = ":not(." + i.klass.buttonToday + ")"), t.$root.find("button" + e + ", select").attr("disabled", !1);
                        },
                        1
                    )
                    .on(
                        "close",
                        function () {
                            t.$root.find("button, select").attr("disabled", !0);
                        },
                        1
                    );
        }
        function n(e, t, i) {
            e = e.match(/[^\x00-\x7F]+|\w+/)[0];
            return i.mm || i.m || (i.m = t.indexOf(e) + 1), e.length;
        }
        function s(e) {
            return e.match(/\w+/)[0].length;
        }
        (i.prototype.set = function (t, i, n) {
            var s = this,
                e = s.item;
            return (
                null === i
                    ? ("clear" == t && (t = "select"), (e[t] = i))
                    : ((e["enable" == t ? "disable" : "flip" == t ? "enable" : t] = s.queue[t]
                        .split(" ")
                        .map(function (e) {
                            return (i = s[e](t, i, n));
                        })
                        .pop()),
                        "select" == t
                            ? s.set("highlight", e.select, n)
                            : "highlight" == t
                                ? s.set("view", e.highlight, n)
                                : t.match(/^(flip|min|max|disable|enable)$/) && (e.select && s.disabled(e.select) && s.set("select", e.select, n), e.highlight && s.disabled(e.highlight) && s.set("highlight", e.highlight, n))),
                    s
            );
        }),
            (i.prototype.get = function (e) {
                return this.item[e];
            }),
            (i.prototype.create = function (e, t, i) {
                var n;
                return (
                    (t = void 0 === t ? e : t) == -1 / 0 || t == 1 / 0
                        ? (n = t)
                        : (t =
                            f.isPlainObject(t) && v.isInteger(t.pick)
                                ? t.obj
                                : f.isArray(t)
                                    ? ((t = new Date(t[0], t[1], t[2])), v.isDate(t) ? t : this.create().obj)
                                    : v.isInteger(t) || v.isDate(t)
                                        ? this.normalize(new Date(t), i)
                                        : this.now(e, t, i)),
                        { year: n || t.getFullYear(), month: n || t.getMonth(), date: n || t.getDate(), day: n || t.getDay(), obj: n || t, pick: n || t.getTime() }
                );
            }),
            (i.prototype.createRange = function (e, t) {
                function i(e) {
                    return !0 === e || f.isArray(e) || v.isDate(e) ? n.create(e) : e;
                }
                var n = this;
                return (
                    v.isInteger(e) || (e = i(e)),
                    v.isInteger(t) || (t = i(t)),
                        v.isInteger(e) && f.isPlainObject(t) ? (e = [t.year, t.month, t.date + e]) : v.isInteger(t) && f.isPlainObject(e) && (t = [e.year, e.month, e.date + t]),
                        { from: i(e), to: i(t) }
                );
            }),
            (i.prototype.withinRange = function (e, t) {
                return (e = this.createRange(e.from, e.to)), t.pick >= e.from.pick && t.pick <= e.to.pick;
            }),
            (i.prototype.overlapRanges = function (e, t) {
                var i = this;
                return (e = i.createRange(e.from, e.to)), (t = i.createRange(t.from, t.to)), i.withinRange(e, t.from) || i.withinRange(e, t.to) || i.withinRange(t, e.from) || i.withinRange(t, e.to);
            }),
            (i.prototype.now = function (e, t, i) {
                return (t = new Date()), i && i.rel && t.setDate(t.getDate() + i.rel), this.normalize(t, i);
            }),
            (i.prototype.navigate = function (e, t, i) {
                var n,
                    s,
                    a,
                    o = f.isArray(t),
                    r = f.isPlainObject(t),
                    l = this.item.view;
                if (o || r) {
                    for (
                        a = r ? ((n = t.year), (s = t.month), t.date) : ((n = +t[0]), (s = +t[1]), +t[2]),
                        i && i.nav && l && l.month !== s && ((n = l.year), (s = l.month)),
                            n = (i = new Date(n, s + (i && i.nav ? i.nav : 0), 1)).getFullYear(),
                            s = i.getMonth();
                        new Date(n, s, a).getMonth() !== s;

                    )
                        --a;
                    t = [n, s, a];
                }
                return t;
            }),
            (i.prototype.normalize = function (e) {
                return e.setHours(0, 0, 0, 0), e;
            }),
            (i.prototype.measure = function (e, t) {
                return v.isInteger(t) ? (t = this.now(e, t, { rel: t })) : t ? "string" == typeof t && (t = this.parse(e, t)) : (t = "min" == e ? -1 / 0 : 1 / 0), t;
            }),
            (i.prototype.viewset = function (e, t) {
                return this.create([t.year, t.month, 1]);
            }),
            (i.prototype.validate = function (e, i, t) {
                var n,
                    s,
                    a,
                    o,
                    r = this,
                    l = i,
                    d = t && t.interval ? t.interval : 1,
                    c = -1 === r.item.enable,
                    u = r.item.min,
                    h = r.item.max,
                    p =
                        c &&
                        r.item.disable.filter(function (e) {
                            var t;
                            return f.isArray(e) && ((t = r.create(e).pick) < i.pick ? (n = !0) : t > i.pick && (s = !0)), v.isInteger(e);
                        }).length;
                if ((!t || (!t.nav && !t.defaultValue)) && ((!c && r.disabled(i)) || (c && r.disabled(i) && (p || n || s)) || (!c && (i.pick <= u.pick || i.pick >= h.pick))))
                    for (
                        c && !p && ((!s && 0 < d) || (!n && d < 0)) && (d *= -1);
                        r.disabled(i) &&
                        (1 < Math.abs(d) && (i.month < l.month || i.month > l.month) && ((i = l), (d = 0 < d ? 1 : -1)),
                            i.pick <= u.pick
                                ? ((a = !0), (d = 1), (i = r.create([u.year, u.month, u.date + (i.pick === u.pick ? 0 : -1)])))
                                : i.pick >= h.pick && ((o = !0), (d = -1), (i = r.create([h.year, h.month, h.date + (i.pick === h.pick ? 0 : 1)]))),
                        !a || !o);

                    )
                        i = r.create([i.year, i.month, i.date + d]);
                return i;
            }),
            (i.prototype.disabled = function (t) {
                var i = this,
                    e =
                        (e = i.item.disable.filter(function (e) {
                            return v.isInteger(e) ? t.day === (i.settings.firstDay ? e : e - 1) % 7 : f.isArray(e) || v.isDate(e) ? t.pick === i.create(e).pick : f.isPlainObject(e) ? i.withinRange(e, t) : void 0;
                        })).length &&
                        !e.filter(function (e) {
                            return (f.isArray(e) && "inverted" == e[3]) || (f.isPlainObject(e) && e.inverted);
                        }).length;
                return -1 === i.item.enable ? !e : e || t.pick < i.item.min.pick || t.pick > i.item.max.pick;
            }),
            (i.prototype.parse = function (e, n, t) {
                var s = this,
                    a = {};
                return n && "string" == typeof n
                    ? ((t && t.format) || ((t = t || {}).format = s.settings.format),
                        s.formats.toArray(t.format).map(function (e) {
                            var t = s.formats[e],
                                i = t ? v.trigger(t, s, [n, a]) : e.replace(/^!/, "").length;
                            t && (a[e] = n.substr(0, i)), (n = n.substr(i));
                        }),
                        [a.yyyy || a.yy, (a.mm || a.m) - 1, a.dd || a.d])
                    : n;
            }),
            (i.prototype.formats = {
                d: function (e, t) {
                    return e ? v.digits(e) : t.date;
                },
                dd: function (e, t) {
                    return e ? 2 : v.lead(t.date);
                },
                ddd: function (e, t) {
                    return e ? s(e) : this.settings.weekdaysShort[t.day];
                },
                dddd: function (e, t) {
                    return e ? s(e) : this.settings.weekdaysFull[t.day];
                },
                m: function (e, t) {
                    return e ? v.digits(e) : t.month + 1;
                },
                mm: function (e, t) {
                    return e ? 2 : v.lead(t.month + 1);
                },
                mmm: function (e, t) {
                    var i = this.settings.monthsShort;
                    return e ? n(e, i, t) : i[t.month];
                },
                mmmm: function (e, t) {
                    var i = this.settings.monthsFull;
                    return e ? n(e, i, t) : i[t.month];
                },
                yy: function (e, t) {
                    return e ? 2 : ("" + t.year).slice(2);
                },
                yyyy: function (e, t) {
                    return e ? 4 : t.year;
                },
                toArray: function (e) {
                    return e.split(/(d{1,4}|m{1,4}|y{4}|yy|!.)/g);
                },
                toString: function (e, t) {
                    var i = this;
                    return i.formats
                        .toArray(e)
                        .map(function (e) {
                            return v.trigger(i.formats[e], i, [0, t]) || e.replace(/^!/, "");
                        })
                        .join("");
                },
            }),
            (i.prototype.isDateExact = function (e, t) {
                return (v.isInteger(e) && v.isInteger(t)) || ("boolean" == typeof e && "boolean" == typeof t)
                    ? e === t
                    : (v.isDate(e) || f.isArray(e)) && (v.isDate(t) || f.isArray(t))
                        ? this.create(e).pick === this.create(t).pick
                        : !(!f.isPlainObject(e) || !f.isPlainObject(t)) && this.isDateExact(e.from, t.from) && this.isDateExact(e.to, t.to);
            }),
            (i.prototype.isDateOverlap = function (e, t) {
                var i = this.settings.firstDay ? 1 : 0;
                return v.isInteger(e) && (v.isDate(t) || f.isArray(t))
                    ? (e = (e % 7) + i) === this.create(t).day + 1
                    : v.isInteger(t) && (v.isDate(e) || f.isArray(e))
                        ? (t = (t % 7) + i) === this.create(e).day + 1
                        : !(!f.isPlainObject(e) || !f.isPlainObject(t)) && this.overlapRanges(e, t);
            }),
            (i.prototype.flipEnable = function (e) {
                var t = this.item;
                t.enable = e || (-1 == t.enable ? 1 : -1);
            }),
            (i.prototype.deactivate = function (e, t) {
                var n = this,
                    s = n.item.disable.slice(0);
                return (
                    "flip" == t
                        ? n.flipEnable()
                        : !1 === t
                            ? (n.flipEnable(1), (s = []))
                            : !0 === t
                                ? (n.flipEnable(-1), (s = []))
                                : t.map(function (e) {
                                    for (var t, i = 0; i < s.length; i += 1)
                                        if (n.isDateExact(e, s[i])) {
                                            t = !0;
                                            break;
                                        }
                                    t || ((v.isInteger(e) || v.isDate(e) || f.isArray(e) || (f.isPlainObject(e) && e.from && e.to)) && s.push(e));
                                }),
                        s
                );
            }),
            (i.prototype.activate = function (e, t) {
                var a = this,
                    o = a.item.disable,
                    r = o.length;
                return (
                    "flip" == t
                        ? a.flipEnable()
                        : !0 === t
                            ? (a.flipEnable(1), (o = []))
                            : !1 === t
                                ? (a.flipEnable(-1), (o = []))
                                : t.map(function (e) {
                                    for (var t, i, n, s = 0; s < r; s += 1) {
                                        if (((i = o[s]), a.isDateExact(i, e))) {
                                            n = !(t = o[s] = null);
                                            break;
                                        }
                                        if (a.isDateOverlap(i, e)) {
                                            f.isPlainObject(e) ? ((e.inverted = !0), (t = e)) : f.isArray(e) ? (t = e)[3] || t.push("inverted") : v.isDate(e) && (t = [e.getFullYear(), e.getMonth(), e.getDate(), "inverted"]);
                                            break;
                                        }
                                    }
                                    if (t)
                                        for (s = 0; s < r; s += 1)
                                            if (a.isDateExact(o[s], e)) {
                                                o[s] = null;
                                                break;
                                            }
                                    if (n)
                                        for (s = 0; s < r; s += 1)
                                            if (a.isDateOverlap(o[s], e)) {
                                                o[s] = null;
                                                break;
                                            }
                                    t && o.push(t);
                                }),
                        o.filter(function (e) {
                            return null != e;
                        })
                );
            }),
            (i.prototype.nodes = function (o) {
                function e(e) {
                    return v.node(
                        "div",
                        " ",
                        l.klass["nav" + (e ? "Next" : "Prev")] + ((e && h.year >= m.year && h.month >= m.month) || (!e && h.year <= f.year && h.month <= f.month) ? " " + l.klass.navDisabled : ""),
                        "data-nav=" + (e || -1) + " " + v.ariaAttr({ role: "button", controls: r.$node[0].id + "_table" }) + ' title="' + (e ? l.labelMonthNext : l.labelMonthPrev) + '"'
                    );
                }
                function t() {
                    var t = l.showMonthsShort ? l.monthsShort : l.monthsFull;
                    return l.selectMonths
                        ? v.node(
                            "select",
                            v.group({
                                min: 0,
                                max: 11,
                                i: 1,
                                node: "option",
                                item: function (e) {
                                    return [t[e], 0, "value=" + e + (h.month == e ? " selected" : "") + ((h.year == f.year && e < f.month) || (h.year == m.year && e > m.month) ? " disabled" : "")];
                                },
                            }),
                            l.klass.selectMonth,
                            (o ? "" : "disabled") + " " + v.ariaAttr({ controls: r.$node[0].id + "_table" }) + ' title="' + l.labelMonthSelect + '"'
                        )
                        : v.node("div", t[h.month], l.klass.month);
                }
                function i() {
                    var t = h.year,
                        e = !0 === l.selectYears ? 5 : ~~(l.selectYears / 2);
                    if (e) {
                        var i = f.year,
                            n = m.year,
                            s = t - e,
                            a = t + e;
                        return (
                            s < i && ((a += i - s), (s = i)),
                            n < a && ((s -= (e = a - n) < (i = s - i) ? e : i), (a = n)),
                                v.node(
                                    "select",
                                    v.group({
                                        min: s,
                                        max: a,
                                        i: 1,
                                        node: "option",
                                        item: function (e) {
                                            return [e, 0, "value=" + e + (t == e ? " selected" : "")];
                                        },
                                    }),
                                    l.klass.selectYear,
                                    (o ? "" : "disabled") + " " + v.ariaAttr({ controls: r.$node[0].id + "_table" }) + ' title="' + l.labelYearSelect + '"'
                                )
                        );
                    }
                    return v.node("div", t, l.klass.year);
                }
                var n,
                    s,
                    r = this,
                    l = r.settings,
                    a = r.item,
                    d = a.now,
                    c = a.select,
                    u = a.highlight,
                    h = a.view,
                    p = a.disable,
                    f = a.min,
                    m = a.max,
                    a =
                        ((n = (l.showWeekdaysFull ? l.weekdaysFull : l.weekdaysShort).slice(0)),
                            (s = l.weekdaysFull.slice(0)),
                        l.firstDay && (n.push(n.shift()), s.push(s.shift())),
                            v.node(
                                "thead",
                                v.node(
                                    "tr",
                                    v.group({
                                        min: 0,
                                        max: 6,
                                        i: 1,
                                        node: "th",
                                        item: function (e) {
                                            return [n[e], l.klass.weekdays, 'scope=col title="' + s[e] + '"'];
                                        },
                                    })
                                )
                            ));
                return (
                    v.node("div", (l.selectYears ? i() + t() : t() + i()) + e() + e(1), l.klass.header) +
                    v.node(
                        "table",
                        a +
                        v.node(
                            "tbody",
                            v.group({
                                min: 0,
                                max: 5,
                                i: 1,
                                node: "tr",
                                item: function (e) {
                                    var t = l.firstDay && 0 === r.create([h.year, h.month, 1]).day ? -7 : 0;
                                    return [
                                        v.group({
                                            min: 7 * e - h.day + t + 1,
                                            max: function () {
                                                return this.min + 7 - 1;
                                            },
                                            i: 1,
                                            node: "td",
                                            item: function (e) {
                                                e = r.create([h.year, h.month, e + (l.firstDay ? 1 : 0)]);
                                                var t,
                                                    i = c && c.pick == e.pick,
                                                    n = u && u.pick == e.pick,
                                                    s = (p && r.disabled(e)) || e.pick < f.pick || e.pick > m.pick,
                                                    a = v.trigger(r.formats.toString, r, [l.format, e]);
                                                return [
                                                    v.node(
                                                        "div",
                                                        e.date,
                                                        ((t = [l.klass.day]).push(h.month == e.month ? l.klass.infocus : l.klass.outfocus),
                                                        d.pick == e.pick && t.push(l.klass.now),
                                                        i && t.push(l.klass.selected),
                                                        n && t.push(l.klass.highlighted),
                                                        s && t.push(l.klass.disabled),
                                                            t.join(" ")),
                                                        "data-pick=" + e.pick + " " + v.ariaAttr({ role: "gridcell", label: a, selected: !(!i || r.$node.val() !== a) || null, activedescendant: !!n || null, disabled: !!s || null })
                                                    ),
                                                    "",
                                                    v.ariaAttr({ role: "presentation" }),
                                                ];
                                            },
                                        }),
                                    ];
                                },
                            })
                        ),
                        l.klass.table,
                        'id="' + r.$node[0].id + '_table" ' + v.ariaAttr({ role: "grid", controls: r.$node[0].id, readonly: !0 })
                    ) +
                    v.node(
                        "div",
                        v.node("button", l.today, l.klass.buttonToday, "type=button data-pick=" + d.pick + (o && !r.disabled(d) ? "" : " disabled") + " " + v.ariaAttr({ controls: r.$node[0].id })) +
                        v.node("button", l.clear, l.klass.buttonClear, "type=button data-clear=1" + (o ? "" : " disabled") + " " + v.ariaAttr({ controls: r.$node[0].id })) +
                        v.node("button", l.close, l.klass.buttonClose, "type=button data-close=true " + (o ? "" : " disabled") + " " + v.ariaAttr({ controls: r.$node[0].id })),
                        l.klass.footer
                    )
                );
            }),
            (i.defaults = {
                labelMonthNext: "Next month",
                labelMonthPrev: "Previous month",
                labelMonthSelect: "Select a month",
                labelYearSelect: "Select a year",
                monthsFull: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                weekdaysFull: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                weekdaysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                today: "Today",
                clear: "Clear",
                close: "Close",
                closeOnSelect: !0,
                closeOnClear: !0,
                updateInput: !0,
                format: "d mmmm, yyyy",
                klass: {
                    table: (t = e.klasses().picker + "__") + "table",
                    header: t + "header",
                    navPrev: t + "nav--prev",
                    navNext: t + "nav--next",
                    navDisabled: t + "nav--disabled",
                    month: t + "month",
                    year: t + "year",
                    selectMonth: t + "select--month",
                    selectYear: t + "select--year",
                    weekdays: t + "weekday",
                    day: t + "day",
                    disabled: t + "day--disabled",
                    selected: t + "day--selected",
                    highlighted: t + "day--highlighted",
                    now: t + "day--today",
                    infocus: t + "day--infocus",
                    outfocus: t + "day--outfocus",
                    footer: t + "footer",
                    buttonClear: t + "button--clear",
                    buttonToday: t + "button--today",
                    buttonClose: t + "button--close",
                },
            }),
            e.extend("pickadate", i);
    });

var Lightview = {
    version: "3.5.1",
    extensions: { flash: "swf", image: "bmp gif jpeg jpg png", iframe: "asp aspx cgi cfm htm html jsp php pl php3 php4 php5 phtml rb rhtml shtml txt", quicktime: "avi mov mpg mpeg movie mp4" },
    pluginspages: { quicktime: "http://www.apple.com/quicktime/download", flash: "http://www.adobe.com/go/getflashplayer" },
    Skins: {
        base: {
            ajax: { type: "get" },
            background: { color: "#fff", opacity: 1 },
            border: { size: 0, color: "#ccc", opacity: 1 },
            continuous: !1,
            controls: { close: "relative", slider: { items: 5 }, text: { previous: "Prev", next: "Next" }, thumbnails: { spinner: { color: "#777" }, mousewheel: !0 }, type: "relative" },
            effects: {
                caption: { show: 180, hide: 180 },
                content: { show: 280, hide: 280 },
                overlay: { show: 240, hide: 280 },
                sides: { show: 150, hide: 180 },
                spinner: { show: 50, hide: 100 },
                slider: { slide: 180 },
                thumbnails: { show: 120, hide: 0, slide: 180, load: 340 },
                window: { show: 120, hide: 50, resize: 200, position: 180 },
            },
            errors: { missing_plugin: "The content your are attempting to view requires the <a href='#{pluginspage}' target='_blank'>#{type} plugin</a>." },
            initialDimensions: { width: 125, height: 125 },
            keyboard: { left: !0, right: !0, esc: !0, space: !0 },
            mousewheel: !0,
            overlay: { close: !0, background: "#202020", opacity: 0.85 },
            padding: 10,
            position: { at: "center", offset: { x: 0, y: 0 } },
            preload: !0,
            radius: { size: 0, position: "background" },
            shadow: { blur: 3, color: "#000", opacity: 0.15 },
            slideshow: { delay: 5e3 },
            spacing: { relative: { horizontal: 60, vertical: 60 }, thumbnails: { horizontal: 60, vertical: 60 }, top: { horizontal: 60, vertical: 60 } },
            spinner: {},
            thumbnail: { icon: !1 },
            viewport: "scale",
            wrapperClass: !1,
            initialTypeOptions: {
                ajax: { keyboard: !1, mousewheel: !1, viewport: "crop" },
                flash: { width: 550, height: 400, params: { allowFullScreen: "true", allowScriptAccess: "always", wmode: "transparent" }, flashvars: {}, keyboard: !1, mousewheel: !1, thumbnail: { icon: "video" }, viewport: "scale" },
                iframe: { width: "100%", height: "100%", attr: { scrolling: "auto" }, keyboard: !1, mousewheel: !1, viewport: "crop" },
                image: { viewport: "scale" },
                inline: { keyboard: !1, mousewheel: !1, viewport: "crop" },
                quicktime: { width: 640, height: 272, params: { autoplay: !0, controller: !0, enablejavascript: !0, loop: !1, scale: "tofit" }, keyboard: !1, mousewheel: !1, thumbnail: { icon: "video" }, viewport: "scale" },
            },
        },
        reset: {},
        dark: { border: { size: 0, color: "#000", opacity: 0.25 }, radius: { size: 5 }, background: "#141414", shadow: { blur: 5, opacity: 0.08 }, overlay: { background: "#2b2b2b", opacity: 0.85 }, spinner: { color: "#777" } },
        light: { border: { opacity: 0.25 }, radius: { size: 5 }, spinner: { color: "#333" } },
        mac: { background: "#fff", border: { size: 0, color: "#dfdfdf", opacity: 0.3 }, shadow: { blur: 3, opacity: 0.08 }, overlay: { background: "#2b2b2b", opacity: 0.85 } },
    },
};
(function ($, window) {
    $(document.documentElement).bind("mousewheel DOMMouseScroll", function (e) {
        var t, i;
        e.originalEvent.wheelDelta ? (t = e.originalEvent.wheelDelta / 120) : e.originalEvent.detail && (t = -e.originalEvent.detail / 3),
        t && ((i = $.Event("lightview:mousewheel")), $(e.target).trigger(i, t), i.isPropagationStopped() && e.stopPropagation(), i.isDefaultPrevented() && e.preventDefault());
    });
    var easing = {},
        J6;
    (J6 = {}),
        $.extend(J6, {
            Quart: function (e) {
                return Math.pow(e, 4);
            },
        }),
        $.each(J6, function (e, t) {
            (easing["easeIn" + e] = t),
                (easing["easeOut" + e] = function (e) {
                    return 1 - t(1 - e);
                }),
                (easing["easeInOut" + e] = function (e) {
                    return e < 0.5 ? t(2 * e) / 2 : 1 - t(-2 * e + 2) / 2;
                });
        }),
        $.each(easing, function (e, t) {
            $.easing[e] || ($.easing[e] = t);
        });
    var _slice = Array.prototype.slice,
        _ = {
            clone: function (e) {
                return $.extend({}, e);
            },
            isElement: function (e) {
                return e && 1 == e.nodeType;
            },
            element: {
                isAttached: function (e) {
                    e = (function (e) {
                        for (var t = e; t && t.parentNode; ) t = t.parentNode;
                        return t;
                    })(e);
                    return !(!e || !e.body);
                },
            },
        },
        Browser =
            ((Y6 = navigator.userAgent),
                {
                    IE: !(!window.attachEvent || -1 !== Y6.indexOf("Opera")) && Z6("MSIE "),
                    Opera: -1 < Y6.indexOf("Opera") && ((!!window.opera && opera.version && parseFloat(opera.version())) || 7.55),
                    WebKit: -1 < Y6.indexOf("AppleWebKit/") && Z6("AppleWebKit/"),
                    Gecko: -1 < Y6.indexOf("Gecko") && -1 === Y6.indexOf("KHTML") && Z6("rv:"),
                    MobileSafari: !!Y6.match(/Apple.*Mobile.*Safari/),
                    Chrome: -1 < Y6.indexOf("Chrome") && Z6("Chrome/"),
                }),
        Y6;
    function Z6(e) {
        e = new RegExp(e + "([\\d.]+)").exec(Y6);
        return !e || parseFloat(e[1]);
    }
    function px(e) {
        var t,
            i = {};
        for (t in e) i[t] = e[t] + "px";
        return i;
    }
    function pyth(e, t) {
        return Math.sqrt(e * e + t * t);
    }
    function degrees(e) {
        return (180 * e) / Math.PI;
    }
    function radian(e) {
        return (e * Math.PI) / 180;
    }
    var getUniqueID =
            ((h7 = 0),
                function (e) {
                    for (e = e || "lv_identity_", h7++; document.getElementById(e + h7); ) h7++;
                    return e + h7;
                }),
        h7;
    function sfcc(e) {
        return String.fromCharCode.apply(String, e.split(","));
    }
    function warn(e) {
        window.console && console[console.warn ? "warn" : "log"](e);
    }
    var Requirements = {
            scripts: {
                jQuery: { required: "1.4.4", available: window.jQuery && jQuery.fn.jquery },
                SWFObject: { required: "2.2", available: window.swfobject && swfobject.ua && "2.2" },
                Spinners: { required: "3.0.0", available: window.Spinners && (Spinners.version || Spinners.Version) },
            },
            check:
                ((m7 = /^(\d+(\.?\d+){0,3})([A-Za-z_-]+[A-Za-z0-9]+)?/),
                    function (e) {
                        (!this.scripts[e].available || (n7(this.scripts[e].available) < n7(this.scripts[e].required) && !this.scripts[e].notified)) &&
                        ((this.scripts[e].notified = !0), warn("Lightview requires " + e + " >= " + this.scripts[e].required));
                    }),
        },
        m7,
        $7,
        X7,
        I7,
        J7;
    function n7(e) {
        for (var e = e.match(m7), t = (e && e[1] && e[1].split(".")) || [], i = 0, n = 0, s = t.length; n < s; n++) i += parseInt(t[n] * Math.pow(10, 6 - 2 * n));
        return e && e[3] ? i - 1 : i;
    }
    function createHTML(e) {
        var t,
            i = "<" + e.tag;
        for (t in e) $.inArray(t, "children html tag".split(" ")) < 0 && (i += " " + t + '="' + e[t] + '"');
        return (
            new RegExp("^(?:area|base|basefont|br|col|frame|hr|img|input|link|isindex|meta|param|range|spacer|wbr)$", "i").test(e.tag)
                ? (i += "/>")
                : ((i += ">"),
                e.children &&
                $.each(e.children, function (e, t) {
                    i += createHTML(t);
                }),
                e.html && (i += e.html),
                    (i += "</" + e.tag + ">")),
                i
        );
    }
    function M7(e, t) {
        var i = e.charAt(0).toUpperCase() + e.substr(1);
        return (function (e, t) {
            for (var i in e) if (void 0 !== I7.style[e[i]]) return "prefix" != t || e[i];
            return !1;
        })((e + " " + J7.join(i + " ") + i).split(" "), t);
    }
    function deepExtend(e, t) {
        for (var i in t) t[i] && t[i].constructor && t[i].constructor === Object ? ((e[i] = _.clone(e[i]) || {}), deepExtend(e[i], t[i])) : (e[i] = t[i]);
        return e;
    }
    function deepExtendClone(e, t) {
        return deepExtend(_.clone(e), t);
    }
    $(document).ready(function () {
        var i = navigator.plugins && navigator.plugins.length;
        function e(e) {
            var t = !1;
            if (i)
                t =
                    0 <=
                    $.map(_slice.call(navigator.plugins), function (e, t) {
                        return e.name;
                    })
                        .join(",")
                        .indexOf(e);
            else
                try {
                    t = new ActiveXObject(e);
                } catch (e) {}
            return !!t;
        }
        Lightview.plugins = i ? { flash: e("Shockwave Flash"), quicktime: e("QuickTime") } : { flash: e("ShockwaveFlash.ShockwaveFlash"), quicktime: e("QuickTime.QuickTime") };
    }),
        $.extend(
            !0,
            Lightview,
            ((I7 = document.createElement("div")),
                (J7 = "Webkit Moz O ms Khtml".split(" ")),
                {
                    init: function () {
                        Requirements.check("jQuery"), (this.support.canvas || Browser.IE) && (window.G_vmlCanvasManager && window.G_vmlCanvasManager.init_(document), Overlay.init(), Window.init(), Window.center(), Keyboard.init());
                    },
                    support: {
                        canvas: !(!(X7 = document.createElement("canvas")).getContext || !X7.getContext("2d")),
                        touch: (function () {
                            try {
                                return !!document.createEvent("TouchEvent");
                            } catch (e) {
                                return !1;
                            }
                        })(),
                        css: {
                            boxShadow: M7("boxShadow"),
                            borderRadius: M7("borderRadius"),
                            transitions:
                                (($7 = !1),
                                    $.each(["WebKitTransitionEvent", "TransitionEvent", "OTransitionEvent"], function (e, t) {
                                        try {
                                            document.createEvent(t), ($7 = !0);
                                        } catch (e) {}
                                    }),
                                    $7),
                            expressions: Browser.IE && Browser.IE < 7,
                            prefixed: function (e) {
                                return M7(e, "prefix");
                            },
                        },
                    },
                })
        );
    var Options =
            ((h8 = Lightview.Skins.base),
                (i8 = deepExtendClone(h8, Lightview.Skins.reset)),
                {
                    create: function (e, t) {
                        (e = e || {}).skin = e.skin || (Lightview.Skins[Window.defaultSkin] ? Window.defaultSkin : "lightview");
                        var i = e.skin ? _.clone(Lightview.Skins[e.skin] || Lightview.Skins[Window.defaultSkin]) : {},
                            i = deepExtendClone(i8, i);
                        t && (i = deepExtend(i, i.initialTypeOptions[t]));
                        var n,
                            s,
                            a,
                            o = deepExtendClone(i, e);
                        o.ajax && ("boolean" == $.type(o.ajax) && ((e = i8.ajax || {}), (n = h8.ajax), (o.ajax = { cache: e.cache || n.cache, type: e.type || n.type })), (o.ajax = deepExtendClone(n, o.ajax))),
                        o.controls && ("string" == $.type(o.controls) ? (o.controls = deepExtendClone(i.controls || i8.controls || h8.controls, { type: o.controls })) : (o.controls = deepExtendClone(h8.controls, o.controls))),
                            "string" == $.type(o.background)
                                ? (o.background = { color: o.background, opacity: 1 })
                                : o.background && ((n = (s = o.background).opacity), (s = s.color), (o.background = { opacity: "number" == $.type(n) ? n : 1, color: "string" == $.type(s) ? s : "#000" })),
                        o.effects ||
                        ((o.effects = {}),
                            $.each(h8.effects, function (t, e) {
                                $.each((o.effects[t] = $.extend({}, e)), function (e) {
                                    o.effects[t][e] = 0;
                                });
                            })),
                        Browser.MobileSafari && (((s = o.effects.overlay).show = 0), (s.hide = 0)),
                        o.effects &&
                        !Lightview.support.canvas &&
                        Browser.IE &&
                        Browser.IE < 9 &&
                        ((a = o.effects),
                        Browser.IE < 7 && $.extend(!0, a, { caption: { show: 0, hide: 0 }, window: { show: 0, hide: 0, resize: 0 }, content: { show: 0, hide: 0 }, spinner: { show: 0, hide: 0 }, slider: { slide: 0 } }),
                            $.extend(!0, a, { sides: { show: 0, hide: 0 } })),
                        o.border &&
                        ((a = i8.border || {}),
                            (c = h8.border),
                            (c =
                                "number" == $.type(o.border)
                                    ? { size: o.border, color: a.color || c.color, opacity: a.opacity || c.opacity }
                                    : "string" == $.type(o.border)
                                        ? { size: a.size || c.size, color: o.border, opacity: a.opacity || c.opacity }
                                        : deepExtendClone(c, o.border)),
                            (o.border = 0 !== c.size && c));
                        var r,
                            l,
                            d,
                            c = h8.position;
                        return (
                            o.position || "number" == $.type(o.position)
                                ? ((r = i8.position || {}),
                                    (r = "string" == $.type(o.position) ? { at: o.position, offset: r.offset || c.offset } : "number" == $.type(o.position) ? { at: "top", offset: { x: 0, y: o.position } } : deepExtendClone(c, o.position)),
                                    (o.position = r))
                                : (o.position = _.clone(c)),
                            (!o.radius && "number" != $.type(o.radius)) ||
                            ((r = i8.radius || {}),
                                (c = h8.radius),
                                (c = "number" == $.type(o.radius) ? { size: o.radius, position: r.position || c.position } : "string" == $.type(o.radius) ? { size: r.size || c.size, position: o.position } : deepExtendClone(c, o.radius)),
                                (o.radius = c)),
                            o.shadow && ((d = i8.shadow), (l = h8.shadow), (d = "boolean" == $.type(o.shadow) ? ((!d || "shadow" != $.type(d)) && d) || l : deepExtendClone(l, o.shadow || {})).blur < 1 && (d = !1), (o.shadow = d)),
                            o.thumbnail &&
                            ((l = i8.thumbnail || {}),
                                (d = h8.thumbnail),
                                (d = "string" == $.type(o.thumbnail) ? { image: o.thumbnail, icon: (i.thumbnail && i.thumbnail.icon) || l.icon || d.icon } : deepExtendClone(d, o.thumbnail)),
                                (o.thumbnail = d)),
                            o.slideshow && "number" == $.type(o.slideshow) && (o.slideshow = { delay: o.slideshow }),
                            "image" != t && (o.slideshow = !1),
                                o
                        );
                    },
                }),
        h8,
        i8,
        Color =
            ((P8 = new RegExp("[0123456789abcdef]", "g")),
                {
                    hex2rgb: S8,
                    hex2fill: function (e, t) {
                        return "undefined" == $.type(t) && (t = 1), "rgba(" + ((t = t), ((e = S8((e = e)))[3] = t), (e.opacity = t), e.join()) + ")";
                    },
                    getSaturatedBW: function (e) {
                        return (
                            "#" +
                            (50 <
                            (function (e) {
                                var t,
                                    i,
                                    n,
                                    s = (e = Q8(e)).red,
                                    a = e.green,
                                    o = e.blue,
                                    r = a < s ? s : a;
                                r < o && (r = o);
                                var l = s < a ? s : a;
                                o < l && (l = o);
                                (n = r / 255),
                                    0 == (i = 0 != r ? (r - l) / r : 0) ? (t = 0) : ((d = (r - s) / (r - l)), (e = (r - a) / (r - l)), (l = (r - o) / (r - l)), (t = s == r ? l - e : a == r ? 2 + d - l : 4 + e - d), (t /= 6) < 0 && (t += 1));
                                (t = Math.round(360 * t)), (i = Math.round(100 * i)), (n = Math.round(100 * n));
                                var d = [];
                                return (d[0] = t), (d[1] = i), (d[2] = n), (d.hue = t), (d.saturation = i), (d.brightness = n), d;
                            })(S8(e))[2]
                                ? "000"
                                : "fff")
                        );
                    },
                }),
        P8;
    function Q8(e) {
        var t = e;
        return (t.red = e[0]), (t.green = e[1]), (t.blue = e[2]), t;
    }
    function S8(e) {
        var t = new Array(3);
        if ((0 == e.indexOf("#") && (e = e.substring(1)), "" != (e = e.toLowerCase()).replace(P8, ""))) return null;
        3 == e.length ? ((t[0] = e.charAt(0) + e.charAt(0)), (t[1] = e.charAt(1) + e.charAt(1)), (t[2] = e.charAt(2) + e.charAt(2))) : ((t[0] = e.substring(0, 2)), (t[1] = e.substring(2, 4)), (t[2] = e.substring(4)));
        for (var i, n = 0; n < t.length; n++) t[n] = ((i = t[n]), parseInt(i, 16));
        return Q8(t);
    }
    var Canvas = {
        init:
            window.G_vmlCanvasManager && !Lightview.support.canvas && Browser.IE
                ? function (e) {
                    G_vmlCanvasManager.initElement(e);
                }
                : function () {},
        resize: function (e, t) {
            $(e)
                .attr({ width: t.width * this.devicePixelRatio, height: t.height * this.devicePixelRatio })
                .css(px(t));
        },
        drawRoundedRectangle: function (e) {
            var t = $.extend(!0, { mergedCorner: !1, expand: !1, top: 0, left: 0, width: 0, height: 0, radius: 0 }, arguments[1] || {}),
                i = t.left,
                n = t.top,
                s = t.width,
                a = t.height,
                o = t.radius;
            t.expand;
            t.expand && ((i -= o), (n -= o), (s += t = 2 * o), (a += t)),
                o
                    ? (e.beginPath(),
                        e.moveTo(i + o, n),
                        e.arc(i + s - o, n + o, o, radian(-90), radian(0), !1),
                        e.arc(i + s - o, n + a - o, o, radian(0), radian(90), !1),
                        e.arc(i + o, n + a - o, o, radian(90), radian(180), !1),
                        e.arc(i + o, n + o, o, radian(-180), radian(-90), !1),
                        e.closePath(),
                        e.fill())
                    : e.fillRect(n, i, s, a);
        },
        createFillStyle: function (e, t) {
            var i, n;
            return (
                "string" == $.type(t)
                    ? (n = Color.hex2fill(t))
                    : "string" == $.type(t.color)
                        ? (n = Color.hex2fill(t.color, "number" == $.type(t.opacity) ? t.opacity.toFixed(5) : 1))
                        : $.isArray(t.color) && ((i = $.extend({ x1: 0, y1: 0, x2: 0, y2: 0 }, arguments[2] || {})), (n = Canvas.Gradient.addColorStops(e.createLinearGradient(i.x1, i.y1, i.x2, i.y2), t.color, t.opacity))),
                    n
            );
        },
        dPA: function (e, t) {
            var i,
                n = $.extend({ x: 0, y: 0, dimensions: !1, color: "#000", background: { color: "#fff", opacity: 0.7, radius: 4 } }, arguments[2] || {}),
                s = n.background;
            s && s.color && ((i = n.dimensions), (e.fillStyle = Color.hex2fill(s.color, s.opacity)), Canvas.drawRoundedRectangle(e, { width: i.width, height: i.height, top: n.y, left: n.x, radius: s.radius || 0 }));
            for (var a = 0, o = t.length; a < o; a++)
                for (var r = 0, l = t[a].length; r < l; r++) {
                    var d = parseInt(t[a].charAt(r)) * (1 / 9) || 0;
                    (e.fillStyle = Color.hex2fill(n.color, d - 0.05)), d && e.fillRect(n.x + r, n.y + a, 1, 1);
                }
        },
    };
    Canvas.Gradient = {
        addColorStops: function (e, t) {
            for (var i = "number" == $.type(arguments[2]) ? arguments[2] : 1, n = 0, s = t.length; n < s; n++) {
                var a = t[n];
                ("undefined" != $.type(a.opacity) && "number" == $.type(a.opacity)) || (a.opacity = 1), e.addColorStop(a.position, Color.hex2fill(a.color, a.opacity * i));
            }
            return e;
        },
    };
    var Bounds = {
            _adjust: function (e) {
                var t = Window.options;
                if (!t) return e;
                if (t.controls)
                    switch (t.controls.type) {
                        case "top":
                            e.height -= Controls.Top.element.innerHeight();
                            break;
                        case "thumbnails":
                            (Window.views && Window.views.length <= 1) || (e.height -= Controls.Thumbnails.element.innerHeight());
                    }
                t = t.position && t.position.offset;
                return t && (t.x && (e.width -= t.x), t.y && (e.height -= t.y)), e;
            },
            viewport: function () {
                var e,
                    t,
                    i = { height: $(window).height(), width: $(window).width() };
                return Browser.MobileSafari && ((e = window.innerWidth), (t = window.innerHeight), (i.width = e), (i.height = t)), Bounds._adjust(i);
            },
            document: function () {
                var e = { height: $(document).height(), width: $(document).width() };
                return (e.height -= $(window).scrollTop()), (e.width -= $(window).scrollLeft()), Bounds._adjust(e);
            },
            inside: function (e) {
                var t = this.viewport(),
                    i = Window.spacing,
                    n = i.horizontal,
                    s = i.vertical,
                    a = e.options,
                    o = a.padding || 0,
                    i = a.border.size || 0,
                    o = (Math.max(n || 0, (a.shadow && a.shadow.size) || 0), Math.max(s || 0, (a.shadow && a.shadow.size) || 0), 2 * i - 2 * o);
                return { height: e.options.viewport ? t.height - o.y : 1 / 0, width: t.width - o.x };
            },
        },
        Overlay =
            ((vaa = Browser.IE && Browser.IE < 7),
                {
                    init: function () {
                        (this.options = { background: "#000", opacity: 0.7 }),
                            this.build(),
                        vaa &&
                        $(window).bind(
                            "resize",
                            $.proxy(function () {
                                Overlay.element && Overlay.element.is(":visible") && Overlay.max();
                            }, this)
                        ),
                            this.draw();
                    },
                    build: function () {
                        var e;
                        (this.element = $(document.createElement("div")).addClass("lv_overlay")),
                        vaa && this.element.css({ position: "absolute" }),
                            $(document.body).prepend(this.element),
                        vaa && ((e = this.element[0].style).setExpression("top", "((!!window.jQuery ? jQuery(window).scrollTop() : 0) + 'px')"), e.setExpression("left", "((!!window.jQuery ? jQuery(window).scrollLeft() : 0) + 'px')")),
                            this.element
                                .hide()
                                .bind(
                                    "click",
                                    $.proxy(function () {
                                        (Window.options && Window.options.overlay && !Window.options.overlay.close) || Window.hide();
                                    }, this)
                                )
                                .bind(
                                    "lightview:mousewheel",
                                    $.proxy(function (e, t) {
                                        (!Window.options ||
                                            Window.options.mousewheel ||
                                            ("thumbnails" == Controls.type && Window.options && Window.options.controls && Window.options.controls.thumbnails && Window.options.controls.thumbnails.mousewheel) ||
                                            (Window.options && Window.options.viewport)) &&
                                        (e.preventDefault(), e.stopPropagation());
                                    }, this)
                                );
                    },
                    show: function (e) {
                        return this.max(), this.element.stop(!0), this.setOpacity(this.options.opacity, this.options.durations.show, e), this;
                    },
                    hide: function (e) {
                        return this.element.stop(!0).fadeOut(this.options.durations.hide || 0, e), this;
                    },
                    setOpacity: function (e, t, i) {
                        this.element.fadeTo(t || 0, e, i);
                    },
                    setOptions: function (e) {
                        (this.options = e), this.draw();
                    },
                    draw: function () {
                        this.element.css({ "background-color": this.options.background }), this.max();
                    },
                    max: function () {
                        var s;
                        Browser.MobileSafari &&
                        Browser.WebKit &&
                        Browser.WebKit < 533.18 &&
                        this.element.css(
                            px(
                                ((s = {}),
                                    $.each(["width", "height"], function (e, t) {
                                        var i = t.substr(0, 1).toUpperCase() + t.substr(1),
                                            n = document.documentElement;
                                        s[t] = (Browser.IE ? Math.max(n["offset" + i], n["scroll" + i]) : (Browser.WebKit ? document.body : n)["scroll" + i]) || 0;
                                    }),
                                    s)
                            )
                        ),
                        Browser.IE && this.element.css(px({ height: $(window).height(), width: $(window).width() }));
                    },
                }),
        vaa,
        Window = {
            defaultSkin: "dark",
            init: function () {
                this.setOptions(arguments[0] || {}), (this._dimensions = { content: { width: 150, height: 150 } }), (this._dimensions.window = this.getLayout(this._dimensions.content).window.dimensions);
                var e = (this.queues = []);
                (e.showhide = $({})), (e.update = $({})), this.build();
            },
            setOptions: function (e) {
                (this.options = Options.create(e || {})), (e = $.extend({ vars: !0 }, arguments[1] || {})).vars && this.setVars();
            },
            setVars: function (e) {
                (e = e || this.options), (this.options = e), (this.spacing = e.spacing[e.controls.type]), (this.padding = e.padding), this.spacing.vertical < 25 && (this.spacing.vertical = 25);
            },
            setSkin: function (e, t) {
                (t = t || {}), e && (t.skin = e);
                var i = $.extend({ vars: !1 }, arguments[2] || {});
                return (
                    this.setOptions(t, { vars: i.vars }),
                        Overlay.setOptions($.extend(!0, { durations: this.options.effects.overlay }, this.options.overlay)),
                        (this.element[0].className = "lv_window lv_window_" + e),
                        Controls.Top.setSkin(e),
                        Controls.Thumbnails.setSkin(e),
                        this.draw(),
                        this
                );
            },
            setDefaultSkin: function (e) {
                Lightview.Skins[e] && (this.defaultSkin = e);
            },
            build: function () {
                var e = { height: 1e3, width: 1e3 };
                (this.element = $(document.createElement("div")).addClass("lv_window")),
                    this.element.append((this.skin = $("<div>").addClass("lv_skin"))),
                    this.skin.append(
                        (this.shadow = $("<div>")
                            .addClass("lv_shadow")
                            .append((this.canvasShadow = $("<canvas>").attr(e))))
                    ),
                    this.skin.append(
                        (this.bubble = $("<div>")
                            .addClass("lv_bubble")
                            .append((this.canvasBubble = $("<canvas>").attr(e))))
                    ),
                    this.skin.append(
                        (this.sideButtonsUnderneath = $("<div>")
                            .addClass("lv_side_buttons_underneath")
                            .append($("<div>").addClass("lv_side lv_side_left").data("side", "previous").append($("<div>").addClass("lv_side_button lv_side_button_previous").data("side", "previous")).hide())
                            .append($("<div>").addClass("lv_side lv_side_right").data("side", "next").append($("<div>").addClass("lv_side_button lv_side_button_next").data("side", "next")).hide())
                            .hide())
                    ),
                    this.element.append((this.content = $("<div>").addClass("lv_content"))),
                    this.element.append(
                        (this.titleCaption = $("<div>")
                            .addClass("lv_title_caption")
                            .hide()
                            .append(
                                (this.titleCaptionSlide = $("<div>")
                                    .addClass("lv_title_caption_slide")
                                    .append((this.title = $("<div>").addClass("lv_title")))
                                    .append((this.caption = $("<div>").addClass("lv_caption"))))
                            ))
                    ),
                    this.element.append(
                        (this.innerPreviousNextOverlays = $("<div>")
                            .addClass("lv_inner_previous_next_overlays")
                            .append($("<div>").addClass("lv_button lv_button_inner_previous_overlay").data("side", "previous"))
                            .append($("<div>").addClass("lv_button lv_button_inner_next_overlay").data("side", "next").hide()))
                    ),
                    this.element.append((this.buttonTopClose = $("<div>").addClass("lv_button_top_close close_lightview").hide())),
                    Controls.Relative.create(),
                    Controls.Top.create(),
                    Controls.Thumbnails.create(),
                    this.skin.append((this.spinnerWrapper = $("<div>").addClass("lv_spinner_wrapper").hide())),
                    $(document.body).prepend(this.element),
                    Canvas.init(this.canvasShadow[0]),
                    Canvas.init(this.canvasBubble[0]),
                    (this.ctxShadow = this.canvasShadow[0].getContext("2d")),
                    (this.ctxBubble = this.canvasBubble[0].getContext("2d")),
                    this.applyFixes(),
                    this.element.hide(),
                    this.startObserving();
            },
            applyFixes: function () {
                var e = $(document.documentElement);
                $(document.body);
                Browser.IE && Browser.IE < 7 && "none" == e.css("background-image") && e.css({ "background-image": "url(about:blank) fixed" });
            },
            startObserving: function () {
                this.stopObserving(),
                    this.element
                        .delegate(
                            ".lv_inner_previous_next_overlays .lv_button, .lv_side_buttons_underneath .lv_side_button, .lv_side_buttons_underneath .lv_side",
                            "mouseover touchmove",
                            $.proxy(function (e) {
                                e = $(e.target).data("side");
                                this.sideButtonsUnderneath
                                    .find(".lv_side_button_" + e)
                                    .first()
                                    .addClass("lv_side_button_out");
                            }, this)
                        )
                        .delegate(
                            ".lv_inner_previous_next_overlays .lv_button, .lv_side_buttons_underneath .lv_side_button, .lv_side_buttons_underneath .lv_side",
                            "mouseout",
                            $.proxy(function (e) {
                                e = $(e.target).data("side");
                                this.sideButtonsUnderneath
                                    .find(".lv_side_button_" + e)
                                    .first()
                                    .removeClass("lv_side_button_out");
                            }, this)
                        )
                        .delegate(
                            ".lv_inner_previous_next_overlays .lv_button, .lv_side_buttons_underneath .lv_side_button, .lv_side_buttons_underneath .lv_side",
                            "click",
                            $.proxy(function (e) {
                                e.preventDefault(), e.stopPropagation(), this[$(e.target).data("side")]();
                            }, this)
                        )
                        .bind(
                            "lightview:mousewheel",
                            $.proxy(function (e, t) {
                                $(e.target).closest(".lv_content")[0] || (this.options && !this.options.viewport) || (e.preventDefault(), e.stopPropagation());
                            }, this)
                        )
                        .delegate(
                            ".close_lightview",
                            "click",
                            $.proxy(function (e) {
                                this.hide();
                            }, this)
                        )
                        .bind(
                            "click",
                            $.proxy(function (e) {
                                (this.options && this.options.overlay && !this.options.overlay.close) || ($(e.target).is(".lv_window, .lv_skin, .lv_shadow") && this.hide());
                            }, this)
                        )
                        .bind(
                            "click",
                            $.proxy(function (e) {
                                var t = sfcc("95,109"),
                                    i = sfcc("108,111,99,97,116,105,111,110"),
                                    n = sfcc("104,114,101,102");
                                this[t] &&
                                e.target == this[t] &&
                                (window[i][n] = sfcc("104,116,116,112,58,47,47,112,114,111,106,101,99,116,115,46,110,105,99,107,115,116,97,107,101,110,98,117,114,103,46,99,111,109,47,108,105,103,104,116,118,105,101,119"));
                            }, this)
                        ),
                    this.innerPreviousNextOverlays.add(this.titleCaption).bind(
                        "lightview:mousewheel",
                        $.proxy(function (e, t) {
                            this.options && this.options.mousewheel && (e.preventDefault(), e.stopPropagation(), this[-1 == t ? "next" : "previous"]());
                        }, this)
                    ),
                Browser.MobileSafari &&
                document.documentElement.addEventListener(
                    "gesturechange",
                    $.proxy(function (e) {
                        this._pinchZoomed = 1 < e.scale;
                    }, this)
                ),
                    $(window)
                        .bind(
                            "scroll",
                            $.proxy(function () {
                                var e, t;
                                this.element.is(":visible") &&
                                !this._pinchZoomed &&
                                ((e = $(window).scrollTop()),
                                    (t = $(window).scrollLeft()),
                                    this.Timeouts.clear("scrolling"),
                                    this.Timeouts.set(
                                        "scrolling",
                                        $.proxy(function () {
                                            $(window).scrollTop() == e && $(window).scrollLeft() == t && this.options.viewport && this.element.is(":visible") && this.center();
                                        }, this),
                                        200
                                    ));
                            }, this)
                        )
                        .bind(
                            Browser.MobileSafari ? "orientationchange" : "resize",
                            $.proxy(function () {
                                this.element.is(":visible") &&
                                ($(window).scrollTop(),
                                    $(window).scrollLeft(),
                                    this.Timeouts.clear("resizing"),
                                    this.Timeouts.set(
                                        "resizing",
                                        $.proxy(function () {
                                            this.element.is(":visible") && (this.center(), "thumbnails" == Controls.type && Controls.Thumbnails.refresh(), Overlay.element.is(":visible") && Overlay.max());
                                        }, this),
                                        1
                                    ));
                            }, this)
                        ),
                    this.spinnerWrapper.bind("click", $.proxy(this.hide, this));
            },
            stopObserving: function () {
                this.element.undelegate(".lv_inner_previous_next_overlays .lv_button, .lv_side_buttons_underneath .lv_side_button").undelegate(".lv_close");
            },
            draw: function () {
                this.layout = this.getLayout(this._dimensions.content);
                var e = this.layout,
                    t = e.bubble,
                    i = t.outer,
                    n = t.inner,
                    s = t.border;
                this.element.is(":visible");
                Lightview.support.canvas || this.skin.css({ width: "100%", height: "100%" });
                var a = this.ctxBubble;
                a.clearRect(0, 0, this.canvasBubble[0].width, this.canvasBubble[0].height),
                    this.element.css(px(this._dimensions.window)),
                    this.skin.css(px(e.skin.dimensions)),
                    this.bubble.css(px(t.position)).css(px(i.dimensions)),
                    this.canvasBubble.attr(i.dimensions),
                    this.innerPreviousNextOverlays.css(px(i.dimensions)).css(px(t.position)),
                    this.sideButtonsUnderneath.css("width", i.dimensions.width + "px").css("margin-left", -0.5 * i.dimensions.width + "px");
                var o = e.content,
                    t = o.dimensions,
                    o = o.position;
                this.content.css(px(t)).css(px(o)),
                    this.titleCaption
                        .add(this.title)
                        .add(this.caption)
                        .css({ width: t.width + "px" });
                t = e.titleCaption.position;
                0 < t.left && 0 < t.top && this.titleCaption.css(px(t)),
                    (a.fillStyle = Canvas.createFillStyle(a, this.options.background, { x1: 0, y1: this.options.border, x2: 0, y2: this.options.border + n.dimensions.height })),
                    this._drawBackgroundPath(),
                    a.fill(),
                s && ((a.fillStyle = Canvas.createFillStyle(a, this.options.border, { x1: 0, y1: 0, x2: 0, y2: i.dimensions.height })), this._drawBackgroundPath(), this._drawBorderPath(), a.fill()),
                    this._drawShadow(),
                this.options.shadow && this.shadow.css(px(e.shadow.position)),
                !Lightview.support.canvas && Browser.IE && Browser.IE < 9 && ($(this.bubble[0].firstChild).addClass("lv_blank_background"), $(this.shadow[0].firstChild).addClass("lv_blank_background"));
            },
            refresh: function () {
                var e,
                    t,
                    i,
                    n = this.element,
                    s = this.content,
                    a = this.content.find(".lv_content_wrapper").first()[0];
                a &&
                this.view &&
                ($(a).css({ width: "auto", height: "auto" }),
                    s.css({ width: "auto", height: "auto" }),
                    (e = parseInt(n.css("top"))),
                    (t = parseInt(n.css("left"))),
                    (i = parseInt(n.css("width"))),
                    n.css({ left: "-25000px", top: "-25000px", width: "15000px", height: "auto" }),
                    (s = this.updateQueue.getMeasureElementDimensions(a)),
                Window.States.get("resized") || (s = this.updateQueue.getFittedDimensions(a, s, this.view)),
                    (this._dimensions.content = s),
                    (this._dimensions.window = this.getLayout(s).window.dimensions),
                    n.css(px({ left: t, top: e, width: i })),
                    this.draw(),
                this.options.viewport && this.place(this.getLayout(s).window.dimensions, 0));
            },
            resizeTo: function (e, t) {
                var i = $.extend({ duration: this.options.effects.window.resize, complete: function () {} }, arguments[2] || {}),
                    n = 2 * ((this.options.radius && this.options.radius.size) || 0);
                this.options.padding;
                (e = Math.max(n, e)), (t = Math.max(n, t));
                var n = this._dimensions.content,
                    s = _.clone(n),
                    a = e - s.width,
                    o = t - s.height,
                    r = _.clone(this._dimensions.window),
                    n = this.getLayout({ width: e, height: t }).window.dimensions,
                    l = n.width - r.width,
                    d = n.height - r.height,
                    c = this,
                    u = this.States.get("controls_from_spacing_x"),
                    h = this.spacing.horizontal - u,
                    p = this.States.get("controls_from_spacing_y"),
                    f = this.spacing.vertical - p,
                    m = this.States.get("controls_from_padding"),
                    v = this.padding - m;
                this.element.attr({ "data-lightview-resize-count": 0 });
                var g = this.view && this.view.url;
                return (
                    this.skin.stop(!0).animate(
                        { "data-lightview-resize-count": 1 },
                        {
                            duration: i.duration,
                            step: function (e, t) {
                                (c._dimensions.content = { width: Math.ceil(t.pos * a + s.width), height: Math.ceil(t.pos * o + s.height) }),
                                    (c._dimensions.window = { width: Math.ceil(t.pos * l + r.width), height: Math.ceil(t.pos * d + r.height) }),
                                    (c.spacing.horizontal = Math.ceil(t.pos * h + u)),
                                    (c.spacing.vertical = Math.ceil(t.pos * f + p)),
                                    (c.padding = Math.ceil(t.pos * v + m)),
                                    c.place(c._dimensions.window, 0),
                                    c.draw();
                            },
                            easing: "easeInOutQuart",
                            queue: !1,
                            complete: $.proxy(function () {
                                this.element.removeAttr("data-lightview-resize-count"), this.view && this.view.url == g && i.complete && (this.skin.removeAttr("lvresizecount", 0), i.complete());
                            }, this),
                        }
                    ),
                        this
                );
            },
            getPlacement: function (e) {
                var t = { top: $(window).scrollTop(), left: $(window).scrollLeft() };
                "top" === (Window.options && Window.options.controls && Window.options.controls.type) && (t.top += Controls.Top.element.innerHeight());
                var i = Bounds.viewport(),
                    n = { top: t.top, left: t.left };
                return (
                    (n.left += Math.floor(0.5 * i.width - 0.5 * e.width)),
                    "center" == this.options.position.at && (n.top += Math.floor(0.5 * i.height - 0.5 * e.height)),
                    n.left < t.left && (n.left = t.left),
                    n.top < t.top && (n.top = t.top),
                    (t = this.options.position.offset) && ((n.top += t.y), (n.left += t.x)),
                        n
                );
            },
            place: function (e, t, i) {
                e = this.getPlacement(e);
                this.bubble.attr("data-lv-fx-placement", 0);
                var n = parseInt(this.element.css("top")) || 0,
                    s = parseInt(this.element.css("left")) || 0,
                    a = e.top - n,
                    o = e.left - s;
                this.bubble.stop(!0).animate(
                    { "data-lv-fx-placement": 1 },
                    {
                        step: $.proxy(function (e, t) {
                            this.element.css({ top: Math.ceil(t.pos * a + n) + "px", left: Math.ceil(t.pos * o + s) + "px" });
                        }, this),
                        easing: "easeInOutQuart",
                        duration: "number" == $.type(t) ? t : this.options.effects.window.position || 0,
                        complete: i,
                    }
                );
            },
            center: function (e, t) {
                this.place(this._dimensions.window, e, t);
            },
            load: function (e, t) {
                var i = this.options && this.options.onHide;
                this.views = e;
                var n = $.extend({ initialDimensionsOnly: !1 }, arguments[2] || {});
                this._reset({ before: this.States.get("visible") && i }), n.initialDimensionsOnly && !this.States.get("visible") ? this.setInitialDimensions(t) : this.setPosition(t);
            },
            setPosition: function (e, t) {
                var i, n, s, a, o;
                e &&
                this.position != e &&
                (this.Timeouts.clear("_m"),
                this._m && ($(this._m).stop().remove(), (this._m = null)),
                    (i = this.position),
                    (n = (o = this.options) && o.controls && o.controls.type),
                    (s = (this.spacing && this.spacing.horizontal) || 0),
                    (a = (this.spacing && this.spacing.vertical) || 0),
                    (o = this.padding || 0),
                    (this.position = e),
                    (this.view = this.views[e - 1]),
                    this.setSkin(this.view.options && this.view.options.skin, this.view.options),
                    this.setVars(this.view.options),
                    this.States.set("controls_from_spacing_x", s),
                    this.States.set("controls_from_spacing_y", a),
                    this.States.set("controls_from_padding", o),
                    n != this.options.controls.type ? this.States.set("controls_type_changed", !0) : this.States.set("controls_type_changed", !1),
                i ||
                (this.options &&
                    "function" == $.type(this.options.onShow) &&
                    this.queues.showhide.queue(
                        $.proxy(function (e) {
                            this.options.onShow.call(Lightview), e();
                        }, this)
                    )),
                    this.update(t));
            },
            setInitialDimensions: function (e) {
                e = this.views[e - 1];
                e &&
                ((e = Options.create(e.options || {})),
                    Overlay.setOptions($.extend(!0, { durations: e.effects.overlay }, e.overlay)),
                    this.setSkin(e.skin, e, { vars: !0 }),
                    (e = e.initialDimensions),
                    this.resizeTo(e.width, e.height, { duration: 0 }));
            },
            getSurroundingIndexes: function () {
                if (!this.views) return {};
                var e = this.position,
                    t = this.views.length;
                return { previous: e <= 1 ? t : e - 1, next: t <= e ? 1 : e + 1 };
            },
            preloadSurroundingImages: function () {
                var e, t, i;
                this.views.length <= 1 ||
                ((e = (t = this.getSurroundingIndexes()).previous),
                    (t = t.next),
                    (i = { previous: e != this.position && this.views[e - 1], next: t != this.position && this.views[t - 1] }),
                1 == this.position && (i.previous = null),
                this.position == this.views.length && (i.next = null),
                    $.each(i, function (e, t) {
                        t && "image" == t.type && t.options.preload && Dimensions.preload(i[e].url, { once: !0 });
                    }));
            },
            play: function (e) {
                function t() {
                    Window.setPosition(Window.getSurroundingIndexes().next, function () {
                        Window.view && Window.options && Window.options.slideshow && Window.States.get("playing") ? Window.Timeouts.set("slideshow", t, Window.options.slideshow.delay) : Window.stop();
                    });
                }
                this.States.set("playing", !0), e ? t() : Window.Timeouts.set("slideshow", t, this.options.slideshow.delay), Controls.play();
            },
            stop: function () {
                Window.Timeouts.clear("slideshow"), this.States.set("playing", !1), Controls.stop();
            },
            mayPrevious: function () {
                return (this.options.continuous && this.views && 1 < this.views.length) || 1 != this.position;
            },
            previous: function (e) {
                this.stop(), (e || this.mayPrevious()) && this.setPosition(this.getSurroundingIndexes().previous);
            },
            mayNext: function () {
                return (this.options.continuous && this.views && 1 < this.views.length) || (this.views && 1 < this.views.length && 1 != this.getSurroundingIndexes().next);
            },
            next: function (e) {
                this.stop(), (e || this.mayNext()) && this.setPosition(this.getSurroundingIndexes().next);
            },
            refreshPreviousNext: function () {
                var e, t, i, n;
                this.innerPreviousNextOverlays.hide().find(".lv_button").hide(),
                    this.view && 1 < this.views.length && "top" != Controls.type
                        ? ((e = this.mayPrevious()),
                            (t = this.mayNext()),
                        (e || t) && this.sideButtonsUnderneath.show(),
                        "image" == this.view.type &&
                        (this.innerPreviousNextOverlays.show(),
                            this.element.find(".lv_button_inner_previous_overlay").fadeTo(
                                0,
                                e ? 1 : 0,
                                e
                                    ? null
                                    : function () {
                                        $(this).hide();
                                    }
                            ),
                            this.element.find(".lv_button_inner_next_overlay").fadeTo(
                                0,
                                t ? 1 : 0,
                                t
                                    ? null
                                    : function () {
                                        $(this).hide();
                                    }
                            )),
                            (i = this.element.find(".lv_side_left")),
                            (n = this.element.find(".lv_side_right")),
                            i.stop(0, 1).fadeTo(
                                e && 0 < parseInt(i.css("opacity")) ? 0 : this.options.effects.sides[e ? "show" : "hide"],
                                e ? 1 : 0,
                                e
                                    ? function () {
                                        $(this).css({ opacity: "inherit" });
                                    }
                                    : function () {
                                        $(this).hide();
                                    }
                            ),
                            n.stop(0, 1).fadeTo(
                                t && 0 < parseInt(n.css("opacity")) ? 0 : this.options.effects.sides[t ? "show" : "hide"],
                                t ? 1 : 0,
                                t
                                    ? function () {
                                        $(this).css({ opacity: "inherit" });
                                    }
                                    : function () {
                                        $(this).hide();
                                    }
                            ))
                        : this.element.find(".lv_side_left, .lv_button_inner_previous_overlay, .lv_side_right, .lv_button_inner_next_overlay").hide();
            },
            hideOverlapping: function () {
                var e, n;
                this.States.get("overlapping") ||
                ((e = $("embed, object, select")),
                    (n = []),
                    e.each(function (e, t) {
                        var i;
                        ($(t).is("object, embed") && (i = $(t).find('param[name="wmode"]')[0]) && i.value && "transparent" == i.value.toLowerCase()) ||
                        $(t).is("[wmode='transparent']") ||
                        n.push({ element: t, visibility: $(t).css("visibility") });
                    }),
                    $.each(n, function (e, t) {
                        $(t.element).css({ visibility: "hidden" });
                    }),
                    this.States.set("overlapping", n));
            },
            restoreOverlapping: function () {
                var e = this.States.get("overlapping");
                e &&
                0 < e.length &&
                $.each(e, function (e, t) {
                    $(t.element).css({ visibility: t.visibility });
                }),
                    this.States.set("overlapping", null);
            },
            restoreOverlappingWithinContent: function () {
                var e = this.States.get("overlapping");
                e &&
                $.each(
                    e,
                    $.proxy(function (e, t) {
                        var i;
                        (i = $(t.element).closest(".lv_content")[0]) && i == this.content[0] && $(t.element).css({ visibility: t.visibility });
                    }, this)
                );
            },
            show: function (t) {
                var e = this.queues.showhide;
                e.queue([]),
                    this.hideOverlapping(),
                this.options.overlay &&
                e.queue(function (e) {
                    Overlay.show(function () {
                        e();
                    });
                }),
                    e.queue(
                        $.proxy(function (e) {
                            this._show(function () {
                                e();
                            });
                        }, this)
                    ),
                "function" == $.type(t) &&
                e.queue(
                    $.proxy(function (e) {
                        t(), e();
                    }),
                    this
                );
            },
            _show: function (e) {
                return (
                    Lightview.support.canvas
                        ? (this.element.stop(!0),
                            this.setOpacity(
                                1,
                                this.options.effects.window.show,
                                $.proxy(function () {
                                    Controls.Top.middle.show(), "top" == Controls.type && Window.options.controls && "top" == Window.options.controls.close && Controls.Top.close_button.show(), this.States.set("visible", !0), e && e();
                                }, this)
                            ))
                        : (Controls.Top.middle.show(),
                        "top" == Controls.type && Window.options.controls && "top" == Window.options.controls.close && Controls.Top.close_button.show(),
                            this.element.show(0, e),
                            this.States.set("visible", !0)),
                        this
                );
            },
            hide: function () {
                var e = this.queues.showhide;
                e.queue([]),
                    e
                        .queue(
                            $.proxy(function (e) {
                                this._hide(
                                    $.proxy(function () {
                                        e();
                                    }, this)
                                );
                            }, this)
                        )
                        .queue(
                            $.proxy(function (e) {
                                this._reset({
                                    before: this.options && this.options.onHide,
                                    after: $.proxy(function () {
                                        Overlay.hide(
                                            $.proxy(function () {
                                                this.restoreOverlapping(), e();
                                            }, this)
                                        );
                                    }, this),
                                });
                            }, this)
                        );
            },
            _hide: function (e) {
                return (
                    this.stopQueues(),
                        Lightview.support.canvas
                            ? this.element.stop(!0, !0).fadeOut(
                                this.options.effects.window.hide || 0,
                                $.proxy(function () {
                                    this.States.set("visible", !1), e && e();
                                }, this)
                            )
                            : (this.States.set("visible", !1), this.element.hide(0, e)),
                        this
                );
            },
            _reset: function () {
                var e = $.extend({ after: !1, before: !1 }, arguments[0] || {});
                "function" == $.type(e.before) && e.before.call(Lightview),
                    this.stopQueues(),
                    this.Timeouts.clear(),
                    this.stop(),
                    Controls.hide(),
                    Controls._reset(),
                    this.titleCaption.hide(),
                    this.innerPreviousNextOverlays.hide().find(".lv_button").hide(),
                    this.cleanContent(),
                    (this.position = null),
                    (Controls.Thumbnails.position = -1),
                    Keyboard.disable(),
                    (this._pinchZoomed = !1),
                    Window.States.set("_m", !1),
                this._m && ($(this._m).stop().remove(), (this._m = null)),
                "function" == $.type(e.after) && e.after.call(Lightview);
            },
            setOpacity: function (e, t, i) {
                this.element.stop(!0, !0).fadeTo(t || 0, e || 1, i);
            },
            createSpinner: function (e) {
                var t;
                this.options.spinner &&
                window.Spinners &&
                (this.spinner && (this.spinner.remove(), (this.spinner = null)),
                    (this.spinner = Spinners.create(this.spinnerWrapper[0], this.options.spinner || {}).play()),
                    (t = Spinners.getDimensions(this.spinnerWrapper[0])),
                    this.spinnerWrapper.css({ height: t.height + "px", width: t.width + "px", "margin-left": Math.ceil(-0.5 * t.width) + "px", "margin-top": Math.ceil(-0.5 * t.height) + "px" }));
            },
            restoreInlineContent: function () {
                var e;
                this.inlineContent &&
                this.inlineMarker &&
                ((e = $(this.inlineContent).data("lv_restore_inline_display")) && $(this.inlineContent).css({ display: e }),
                    $(this.inlineMarker).before(this.inlineContent).remove(),
                    (this.inlineMarker = null),
                    (this.inlineContent = null));
            },
            cleanContent: function () {
                var e = this.content.find(".lv_content_wrapper")[0],
                    t = $(e || this.content)
                        .children()
                        .first()[0],
                    i = this.inlineMarker && this.inlineContent;
                if ((this.restoreInlineContent(), t))
                    switch (t.tagName.toLowerCase()) {
                        case "object":
                            try {
                                t.Stop();
                            } catch (e) {}
                            try {
                                t.innerHTML = "";
                            } catch (e) {}
                            t.parentNode ? $(t).remove() : (t = function () {});
                            break;
                        case "iframe":
                            (t.src = "//about:blank"), $(t).remove();
                            break;
                        default:
                            i || $(t).remove();
                    }
                Window.Timeouts.clear("preloading_images"),
                (e = Window.States.get("preloading_images")) &&
                ($.each(e, function (e, t) {
                    t.onload = function () {};
                }),
                    Window.States.set("preloading_images", !1)),
                    this.content.html("");
            },
            stopQueues: function () {
                this.queues.update.queue([]), this.content.stop(!0), this.skin.stop(!0), this.bubble.stop(!0), this.spinnerWrapper.stop(!0);
            },
            setTitleCaption: function (e) {
                this.titleCaption.removeClass("lv_has_caption lv_has_title").css({ width: (e || this._dimensions.content.width) + "px" }),
                    this.title[this.view.title ? "show" : "hide"]().html(""),
                    this.caption[this.view.caption ? "show" : "hide"]().html(""),
                this.view.title && (this.title.html(this.view.title), this.titleCaption.addClass("lv_has_title")),
                this.view.caption && (this.caption.html(this.view.caption), this.titleCaption.addClass("lv_has_caption"));
            },
            update:
                ((_da = function (c, e) {
                    if (!Window.States.get("_m") && !Window._m) {
                        for (
                            var u,
                                t,
                                c = c || null,
                                i = [
                                    "",
                                    "",
                                    "",
                                    "",
                                    "00006000600660060060666060060606666060606",
                                    "00006000606000060060060060060606000060606",
                                    "00006000606066066660060060060606666060606",
                                    "00006000606006060060060060060606000060606",
                                    "000066606006600600600600066006066660066600000",
                                    "",
                                    "",
                                    "",
                                    "",
                                ],
                                n = 0,
                                s = i.length,
                                a = 0,
                                o = i.length;
                            a < o;
                            a++
                        )
                            n = Math.max(n, i[a].length || 0);
                        t = { width: n, height: s };
                        var r = Window.getLayout(),
                            s = (Window.view.type, r.content.position),
                            r = Window.options,
                            l = s.top - r.padding - ((r.border && r.border.size) || 0) - t.height - 10,
                            d = s.left + e.width - t.width,
                            e = parseInt(Window.buttonTopClose.css("right"));
                        NaN !== e && 0 <= e && (d = s.left), Window.States.set("_m", !0), p(t, l, d, i, 0);
                        var h = Window.options.effects;
                        Window.Timeouts.set(
                            "_m",
                            function () {
                                Window._m &&
                                $(Window._m).fadeTo(h.caption.show, 1, function () {
                                    Window._m &&
                                    (p(t, l, d, i),
                                        Window.Timeouts.set(
                                            "_m",
                                            function () {
                                                Window._m &&
                                                (p(t, l, d, i),
                                                    Window.Timeouts.set(
                                                        "_m",
                                                        function () {
                                                            Window._m &&
                                                            $(Window._m).fadeTo(Lightview.support.canvas ? 900 : 0, 0, function () {
                                                                Window._m && $(Window._m).remove();
                                                            });
                                                        },
                                                        1800
                                                    ));
                                            },
                                            1800
                                        ));
                                });
                            },
                            h.spinner.hide + h.content.show
                        );
                    }
                    function p(e, t, i, n, s) {
                        var a = {},
                            o = sfcc("111,112,97,99,105,116,121"),
                            r = sfcc("122,45,105,110,100,101,120"),
                            l = sfcc("118,105,115,105,98,105,108,105,116,121"),
                            d = sfcc("99,117,114,115,111,114");
                        (a[o] = "number" == $.type(s) ? s : 1),
                            (a[r] = 1e5),
                            (a[l] = sfcc("118,105,115,105,98,105,108,101")),
                            (a[d] = sfcc("112,111,105,110,116,101,114")),
                            $(document.body).append(
                                $((u = document.createElement("canvas")))
                                    .attr(e)
                                    .css({ position: "absolute", top: t, left: i })
                                    .css(a)
                            ),
                            Canvas.init(u),
                            (c = u.getContext("2d")),
                        Window._m && ($(Window._m).remove(), (Window._m = null)),
                            (Window._m = u),
                            $(Window.skin).append(Window._m),
                            ((u = e).x = 0),
                            (u.y = 0),
                            Canvas.dPA(c, n, { x: u.x, y: u.y, dimensions: e });
                    }
                }),
                    function (t) {
                        var e,
                            i = this.queues.update,
                            r = { width: this.options.width, height: this.options.height };
                        this.stopQueues(),
                            this.titleCaption.stop(!0),
                            this.element.find(".lv_side_left, .lv_button_inner_previous_overlay, .lv_side_right, .lv_button_inner_next_overlay").stop(!0),
                            this.States.set("resized", !1),
                        this.States.get("controls_type_changed") &&
                        i.queue(
                            $.proxy(function (e) {
                                Controls.hide(), e();
                            }, this)
                        ),
                        this.titleCaption.is(":visible") &&
                        i.queue(
                            $.proxy(function (e) {
                                this.titleCaption.fadeOut(this.options.effects.caption.hide, e);
                            }, this)
                        ),
                        this.spinner &&
                        this.spinnerWrapper.is(":visible") &&
                        i.queue(
                            $.proxy(function (e) {
                                this.spinnerWrapper.fadeOut(
                                    this.options.effects.spinner.hide,
                                    $.proxy(function () {
                                        this.spinner && this.spinner.remove(), e();
                                    }, this)
                                );
                            }, this)
                        ),
                            i.queue(
                                $.proxy(function (e) {
                                    this.content.animate(
                                        { opacity: 0 },
                                        {
                                            complete: $.proxy(function () {
                                                this.cleanContent(), this.content.hide(), e();
                                            }, this),
                                            queue: !1,
                                            duration: this.options.effects.content.hide,
                                        }
                                    );
                                }, this)
                            ),
                        0 < this.options.effects.window.resize &&
                        i.queue(
                            $.proxy(function (e) {
                                this.createSpinner(),
                                    this.spinnerWrapper.fadeTo(this.options.effects.spinner.show, 1, function () {
                                        $(this).css({ opacity: "inherit" }), e();
                                    });
                            }, this)
                        ),
                            i.queue(
                                $.proxy(function (e) {
                                    var t,
                                        i = 0,
                                        n = 0;
                                    "string" == $.type(r.width) && -1 < r.width.indexOf("%") && (i = parseFloat(r.width) / 100),
                                    "string" == $.type(r.height) && -1 < r.height.indexOf("%") && (n = parseFloat(r.height) / 100),
                                    (i || n) && ((t = Bounds[this.options.viewport ? "viewport" : "document"]()), i && (r.width = Math.floor(t.width * i)), n && (r.height = Math.floor(t.height * n))),
                                        e();
                                }, this)
                            ),
                        /^(quicktime|flash)$/.test(this.view.type) &&
                        !Lightview.plugins[this.view.type] &&
                        ((e = (e = (e = (this.options.errors && this.options.errors.missing_plugin) || "").replace("#{pluginspage}", Lightview.pluginspages[this.view.type])).replace("#{type}", this.view.type)),
                            $.extend(this.view, { type: "html", title: null, caption: null, url: e })),
                            i.queue(
                                $.proxy(function (n) {
                                    switch (this.view.type) {
                                        case "image":
                                            Dimensions.get(
                                                this.view.url,
                                                { type: this.view.type },
                                                $.proxy(function (t, i) {
                                                    (this.options.width || this.options.height) && (t = this.Dimensions.scaleWithin({ width: this.options.width || t.width, height: this.options.height || t.height }, t)),
                                                        (t = this.Dimensions.fit(t, this.view)),
                                                        this.resizeTo(t.width, t.height, {
                                                            complete: $.proxy(function () {
                                                                var e = !this.content.is(":visible");
                                                                "gif" != this.view.extension && Browser.IE && Browser.IE < 8 && this.States.get("resized")
                                                                    ? aea(
                                                                        $("<div>")
                                                                            .css(px(t))
                                                                            .addClass("lv_content_image")
                                                                            .css({ filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' + i.image.src + '", sizingMethod="scale")' })
                                                                    )
                                                                    : aea($("<img>").css(px(t)).addClass("lv_content_image").attr({ src: i.image.src, alt: "" })),
                                                                    _da(null, t),
                                                                e && this.content.hide(),
                                                                    n();
                                                            }, this),
                                                        });
                                                }, this)
                                            );
                                            break;
                                        case "flash":
                                            Requirements.check("SWFObject");
                                            var i = this.Dimensions.fit(r, this.view);
                                            this.resizeTo(i.width, i.height, {
                                                complete: $.proxy(function () {
                                                    var e = getUniqueID(),
                                                        t = $("<div>").attr({ id: e });
                                                    t.css(px(i)),
                                                        aea(t),
                                                        swfobject.embedSWF(this.view.url, e, "" + i.width, "" + i.height, "9.0.0", null, this.view.options.flashvars || null, this.view.options.params || {}),
                                                        $("#" + e).addClass("lv_content_flash"),
                                                        _da(null, i),
                                                        n();
                                                }, this),
                                            });
                                            break;
                                        case "quicktime":
                                            var s = !!this.view.options.params.controller;
                                            !Browser.MobileSafari && "quicktime" == this.view.type && s && (r.height += 16);
                                            i = this.Dimensions.fit(r, this.view);
                                            this.resizeTo(i.width, i.height, {
                                                complete: $.proxy(function () {
                                                    var e,
                                                        t = { tag: "object", class: "lv_content_object", width: i.width, height: i.height, pluginspage: Lightview.pluginspages[this.view.type], children: [] };
                                                    for (e in this.view.options.params) t.children.push({ tag: "param", name: e, value: this.view.options.params[e] });
                                                    $.merge(t.children, [{ tag: "param", name: "src", value: this.view.url }]),
                                                        $.extend(
                                                            t,
                                                            Browser.IE ? { codebase: "http://www.apple.com/qtactivex/qtplugin.cab", classid: "clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" } : { data: this.view.url, type: "video/quicktime" }
                                                        ),
                                                        aea(createHTML(t)),
                                                        _da(null, i),
                                                    s &&
                                                    this.Timeouts.set(
                                                        $.proxy(function () {
                                                            try {
                                                                var e = this.content.find("object")[0];
                                                                "SetControllerVisible" in e && e.SetControllerVisible(controller);
                                                            } catch (e) {}
                                                        }, this),
                                                        1
                                                    ),
                                                        n();
                                                }, this),
                                            });
                                            break;
                                        case "iframe":
                                        case "iframe_movie":
                                            var i = this.Dimensions.fit(r, this.view),
                                                e = $("<iframe webkitAllowFullScreen mozallowfullscreen allowFullScreen>").attr({ frameBorder: 0, hspace: 0, width: i.width, height: i.height, src: this.view.url }).addClass("lv_content_iframe");
                                            this.view.options.attr && e.attr(this.view.options.attr),
                                                this.resizeTo(i.width, i.height, {
                                                    complete: $.proxy(function () {
                                                        aea(e), _da(null, i), n();
                                                    }, this),
                                                });
                                            break;
                                        case "html":
                                            var t = $("<div>").append(this.view.url).addClass("lv_content_html");
                                            this.updateQueue.update(
                                                t,
                                                this.view,
                                                $.proxy(function () {
                                                    _da(null, this._dimensions.content), n();
                                                }, this)
                                            );
                                            break;
                                        case "inline":
                                            var a = this.view.url;
                                            /^(#)/.test(a) && (a = a.substr(1));
                                            a = $("#" + a)[0];
                                            if (!a) return;
                                            (this.inlineContent = a),
                                                this.updateQueue.update(
                                                    a,
                                                    this.view,
                                                    $.proxy(function () {
                                                        _da(null, this._dimensions.content), n();
                                                    }, this)
                                                );
                                            break;
                                        case "ajax":
                                            $.extend({ url: this.view.url }, this.view.options.ajax || {});
                                            var o = this.view.url,
                                                o = this.view.url,
                                                a = this.view.options.ajax || {};
                                            $.ajax({
                                                url: o,
                                                type: a.type || "get",
                                                dataType: a.dataType || "html",
                                                data: a.data || {},
                                                success: $.proxy(function (e, t, i) {
                                                    o == this.view.url &&
                                                    this.updateQueue.update(
                                                        i.responseText,
                                                        this.view,
                                                        $.proxy(function () {
                                                            _da(null, this._dimensions.content), n();
                                                        }, this)
                                                    );
                                                }, this),
                                            });
                                    }
                                }, this)
                            ),
                            i.queue(
                                $.proxy(function (e) {
                                    this.preloadSurroundingImages(), e();
                                }, this)
                            ),
                        "function" == $.type(this.options.afterUpdate) &&
                        i.queue(
                            $.proxy(function (e) {
                                this.content.is(":visible") || this.content.show().css({ opacity: 0 });
                                var t = this.content.find(".lv_content_wrapper")[0];
                                this.options.afterUpdate.call(Lightview, t, this.position), e();
                            }, this)
                        ),
                            i.queue(
                                $.proxy(function (e) {
                                    this.spinnerWrapper.fadeOut(
                                        this.options.effects.spinner.hide,
                                        $.proxy(function () {
                                            this.spinner && this.spinner.remove(), e();
                                        }, this)
                                    );
                                }, this)
                            ),
                            i.queue(
                                $.proxy(function (e) {
                                    Controls.set(this.options.controls.type), "thumbnails" == Controls.type && -1 == Controls.Thumbnails.position && Controls.Thumbnails.moveTo(this.position, !0), Controls.refresh(), e();
                                }, this)
                            ),
                            i.queue(
                                $.proxy(function (e) {
                                    this.refreshPreviousNext(), e();
                                }, this)
                            ),
                            i.queue(
                                $.proxy(function (e) {
                                    this.restoreOverlappingWithinContent(),
                                        this.content.fadeTo(
                                            this.options.effects.content.show,
                                            Browser.Chrome && 18 <= Browser.Chrome ? 0.9999999 : 1,
                                            $.proxy(function () {
                                                e();
                                            }, this)
                                        );
                                }, this)
                            ),
                        (this.view.title || this.view.caption) &&
                        i.queue(
                            $.proxy(function (e) {
                                this.setTitleCaption(), this.titleCaption.fadeTo(this.options.effects.caption.show, 1, e);
                            }, this)
                        ),
                            i.queue(
                                $.proxy(function (e) {
                                    Keyboard.enable(), e();
                                }, this)
                            ),
                        t &&
                        i.queue(function (e) {
                            t(), e();
                        });
                    }),
            _update: function (e) {
                this.measureElement.attr("style", ""), this.measureElement.html(e);
            },
            getLayout: function (e, t) {
                var i = {},
                    n = (this.options.border && this.options.border.size) || 0,
                    s = this.padding || 0,
                    a = (this.options.radius && "background" == this.options.radius.position && this.options.radius.size) || 0,
                    o = n && this.options.radius && "border" == this.options.radius.position ? this.options.radius.size || 0 : a + n,
                    e = e || this._dimensions.content;
                n && o && n + a < o && (o = n + a);
                var r,
                    l = (this.options.shadow && this.options.shadow.blur) || 0,
                    d = Math.max(l, this.spacing.horizontal),
                    c = Math.max(l, this.spacing.vertical),
                    u = { width: e.width + 2 * s, height: e.height + 2 * s },
                    h = { height: u.height + 2 * n, width: u.width + 2 * n },
                    p = _.clone(h);
                this.options.shadow &&
                ((p.width += 2 * this.options.shadow.blur),
                    (p.height += 2 * this.options.shadow.blur),
                    (r = { top: c - this.options.shadow.blur, left: d - this.options.shadow.blur }),
                this.options.shadow.offset && ((r.top += this.options.shadow.offset.y), (r.left += this.options.shadow.offset.x)));
                var f,
                    m,
                    v,
                    g = { top: c, left: d },
                    w = { width: h.width + 2 * d, height: h.height + 2 * c },
                    y = { top: 0, left: 0 },
                    b = { width: 0, height: 0 };
                return (
                    arguments[0] &&
                    this.view &&
                    (this.view.title || this.view.caption) &&
                    ((f = !this.element.is(":visible")),
                        (m = !this.titleCaption.is(":visible")),
                        this.titleCaption.add(this.title).add(this.caption).css({ width: "auto" }),
                    f && this.element.show(),
                    m && this.titleCaption.show(),
                        (v = this.title.html()),
                        (l = this.caption.html()),
                        this.setTitleCaption(e.width),
                        (b = { width: this.titleCaption.outerWidth(!0), height: this.titleCaption.outerHeight(!0) }),
                        this.title.html(v),
                        this.caption.html(l),
                    m && this.titleCaption.hide(),
                    f && this.element.hide(),
                        (y = { top: g.top + h.height, left: g.left + n + s })),
                        $.extend(i, {
                            window: { dimensions: { width: w.width, height: w.height + b.height } },
                            skin: { position: { top: c, left: d }, dimensions: w },
                            content: { position: { top: g.top + n + s, left: g.left + n + s }, dimensions: $.extend({}, this._dimensions.content) },
                            bubble: { border: n, inner: { radius: a, padding: s, dimensions: u, position: { top: n, left: n } }, outer: { radius: o, dimensions: h }, position: g },
                            shadow: { position: r, dimensions: p },
                            titleCaption: { position: y, dimensions: b },
                        }),
                        i
                );
            },
            _drawBackgroundPath: function () {
                var e = this.ctxBubble,
                    t = this.layout,
                    i = t.bubble,
                    n = i.border,
                    s = i.inner.radius,
                    a = t.bubble.inner.dimensions,
                    o = a.width,
                    i = a.height,
                    t = s,
                    a = 0;
                n && ((t += n), (a += n)),
                    e.beginPath(t, a),
                    e.moveTo(t, a),
                    s ? (e.arc(n + o - s, n + s, s, radian(-90), radian(0), !1), (t = n + o), (a = n + s)) : ((t += o), e.lineTo(t, a)),
                    (a += i - 2 * s),
                    e.lineTo(t, a),
                    s ? (e.arc(n + o - s, n + i - s, s, radian(0), radian(90), !1), (t = n + o - s), (a = n + i)) : e.lineTo(t, a),
                    (t -= o - 2 * s),
                    e.lineTo(t, a),
                    s ? (e.arc(n + s, n + i - s, s, radian(90), radian(180), !1), (a = (t = n) + i - s)) : e.lineTo(t, a),
                    (a -= i - 2 * s),
                    e.lineTo(t, a),
                s && (e.arc(n + s, n + s, s, radian(-180), radian(-90), !1), (t = n + s), (a = n), (t += 1)),
                    e.lineTo(t, a),
                n || e.closePath();
            },
            _drawBorderPath: function () {
                var e = this.layout,
                    t = this.ctxBubble,
                    i = e.bubble.outer.radius,
                    n = e.bubble.outer.dimensions,
                    s = n.width,
                    a = n.height,
                    e = i,
                    n = 0;
                i && (e += 1),
                    (e = i),
                    t.moveTo(e, n),
                    i ? (t.arc(i, i, i, radian(-90), radian(-180), !0), (e = 0), (n = i)) : t.lineTo(e, n),
                    (n += a - 2 * i),
                    t.lineTo(e, n),
                    i ? (t.arc(i, a - i, i, radian(-180), radian(-270), !0), (e = i), (n = a)) : t.lineTo(e, n),
                    (e += s - 2 * i),
                    t.lineTo(e, n),
                    i ? (t.arc(s - i, a - i, i, radian(90), radian(0), !0), (e = s), (n = a - i)) : t.lineTo(e, n),
                    (n -= a - 2 * i),
                    t.lineTo(e, n),
                i && (t.arc(s - i, i, i, radian(0), radian(-90), !0), (e = s - i), (n = 0), (e += 1)),
                    t.lineTo(e, n),
                    t.closePath();
            },
            _drawShadow: function () {
                if ((this.ctxShadow.clearRect(0, 0, this.canvasShadow[0].width, this.canvasShadow[0].height), this.options.shadow)) {
                    this.shadow.show();
                    var e = this.layout,
                        t = e.bubble.outer.radius,
                        i = e.bubble.outer.dimensions,
                        n = this.options.shadow,
                        s = this.options.shadow.blur,
                        a = this.ctxShadow;
                    this.shadow.css(px(e.shadow.dimensions)), this.canvasShadow.attr(e.shadow.dimensions).css({ top: 0, left: 0 });
                    for (var o, r = n.opacity, l = n.blur + 1, d = 0; d <= s; d++)
                        (a.fillStyle = Color.hex2fill(n.color, ((o = d * (1 / l)), (Math.PI / 2 - Math.pow(o, Math.cos(o) * Math.PI)) * (r / l)))),
                            Canvas.drawRoundedRectangle(a, { width: i.width + 2 * d, height: i.height + 2 * d, top: s - d, left: s - d, radius: t + d }),
                            a.fill();
                    this.shadow.show();
                } else this.shadow.hide();
            },
        },
        _da,
        zga,
        Aga;
    function aea(e) {
        var t = $("<div>").addClass("lv_content_wrapper");
        Window.options.wrapperClass && t.addClass(Window.options.wrapperClass), Window.options.skin && t.addClass("lv_content_" + Window.options.skin), Window.content.html(t), t.html(e);
    }
    function View() {
        this.initialize.apply(this, arguments);
    }
    (Window.Timeouts =
        ((zga = {}),
            (Aga = 0),
            {
                set: function (e, t, i) {
                    if (("string" == $.type(e) && this.clear(e), "function" == $.type(e))) {
                        for (i = t, t = e; zga["timeout_" + Aga]; ) Aga++;
                        e = "timeout_" + Aga;
                    }
                    zga[e] = window.setTimeout(function () {
                        t && t(), (zga[e] = null), delete zga[e];
                    }, i);
                },
                get: function (e) {
                    return zga[e];
                },
                clear: function (e) {
                    e ||
                    ($.each(zga, function (e, t) {
                        window.clearTimeout(t), (zga[e] = null), delete zga[e];
                    }),
                        (zga = {})),
                    zga[e] && (window.clearTimeout(zga[e]), (zga[e] = null), delete zga[e]);
                },
            })),
        (Window.States = {
            _states: {},
            set: function (e, t) {
                this._states[e] = t;
            },
            get: function (e) {
                return this._states[e] || !1;
            },
        }),
        $.extend(View.prototype, {
            initialize: function (object) {
                var options = arguments[1] || {},
                    data = {},
                    element;
                return (
                    "string" == $.type(object)
                        ? (object = { url: object })
                        : object &&
                        1 == object.nodeType &&
                        ((element = $(object)),
                            (object = {
                                element: element[0],
                                url: element.attr("href"),
                                title: element.data("lightview-title"),
                                caption: element.data("lightview-caption"),
                                group: element.data("lightview-group"),
                                extension: element.data("lightview-extension"),
                                type: element.data("lightview-type"),
                                options: (element.data("lightview-options") && eval("({" + element.data("lightview-options") + "})")) || {},
                            })),
                    object && (object.extension || (object.extension = detectExtension(object.url)), object.type || (object.type = detectType(object.url, object.extension))),
                        object && object.options ? (object.options = $.extend(!0, _.clone(options), _.clone(object.options))) : (object.options = _.clone(options)),
                        (object.options = Options.create(object.options, object.type)),
                        $.extend(this, object),
                        this
                );
            },
            isExternal: function () {
                return -1 < $.inArray(this.type, "iframe inline ajax".split(" "));
            },
            isMedia: function () {
                return !this.isExternal();
            },
        }),
        (Window.Dimensions = {
            fit: function (e) {
                if (!Window.view.options.viewport) return Window.States.set("resized", !1), e;
                var t = Bounds.viewport(),
                    i = Window.getLayout(e).window.dimensions,
                    n = 1;
                if ("scale" == Window.view.options.viewport) {
                    for (var s, a, o = e, r = 5; 0 < r && (i.width > t.width || i.height > t.height); )
                        Window.States.set("resized", !0),
                            r--,
                        i.width < 150 && (r = 0),
                        100 < o.width &&
                        100 < o.height &&
                        ((a = s = 1), i.width > t.width && (s = t.width / i.width), i.height > t.height && (a = t.height / i.height), (n = Math.min(s, a)), (o = { width: Math.round(o.width * n), height: Math.round(o.height * n) })),
                            (i = Window.getLayout(o).window.dimensions);
                    e = o;
                } else {
                    for (var l = e, r = 3; 0 < r && (i.width > t.width || i.height > t.height); )
                        Window.States.set("resized", !0),
                            r--,
                        i.width < 150 && (r = 0),
                        i.width > t.width && (l.width -= i.width - t.width),
                        i.height > t.height && (l.height -= i.height - t.height),
                            (i = Window.getLayout(l).window.dimensions);
                    e = l;
                }
                return e;
            },
            scaleWithin: function (e, t) {
                var i = t;
                return (
                    ((e.width && t.width > e.width) || (e.height && t.height > e.height)) &&
                    ((t = this.getBoundsScale(t, { width: e.width || t.width, height: e.height || t.height })), e.width && (i.width = Math.round(i.width * t)), e.height && (i.height = Math.round(i.height * t))),
                        i
                );
            },
            getBoundsScale: function (e, t) {
                return Math.min(t.height / e.height, t.width / e.width, 1);
            },
            scale: function (e, t) {
                return { width: (e.width * t).round(), height: (e.height * t).round() };
            },
            scaleToBounds: function (e, t) {
                t = Math.min(t.height / e.height, t.width / e.width, 1);
                return { width: Math.round(e.width * t), height: Math.round(e.height * t) };
            },
        });
    var Keyboard = {
            enabled: !1,
            keyCode: { left: 37, right: 39, space: 32, esc: 27 },
            enable: function () {
                this.fetchOptions();
            },
            disable: function () {
                this.enabled = !1;
            },
            init: function () {
                this.fetchOptions(), $(document).keydown($.proxy(this.onkeydown, this)), $(document).keyup($.proxy(this.onkeyup, this)), Keyboard.disable();
            },
            fetchOptions: function () {
                this.enabled = Window.options.keyboard;
            },
            onkeydown: function (e) {
                if (this.enabled && Window.element.is(":visible")) {
                    var t = this.getKeyByKeyCode(e.keyCode);
                    if (t && (!t || !this.enabled || this.enabled[t]))
                        switch ((e.preventDefault(), e.stopPropagation(), t)) {
                            case "left":
                                Window.previous();
                                break;
                            case "right":
                                Window.next();
                                break;
                            case "space":
                                Window.views && 1 < Window.views.length && Window[Window.States.get("playing") ? "stop" : "play"]();
                        }
                }
            },
            onkeyup: function (e) {
                this.enabled && Window.element.is(":visible") && (!(e = this.getKeyByKeyCode(e.keyCode)) || (e && this.enabled && !this.enabled[e]) || ("esc" === e && Window.hide()));
            },
            getKeyByKeyCode: function (e) {
                for (var t in this.keyCode) if (this.keyCode[t] == e) return t;
                return null;
            },
        },
        Dimensions = {
            get: function (e, t, i) {
                "function" == $.type(t) && ((i = t), (t = {})), (t = $.extend({ track: !0, type: !1, lifetime: 3e5 }, t || {}));
                var n,
                    s = Dimensions.cache.get(e),
                    a = t.type || detectType(e),
                    o = { type: a, callback: i };
                s
                    ? i && i($.extend({}, s.dimensions), s.data)
                    : (t.track && Dimensions.loading.clear(e),
                    "image" === a &&
                    (((n = new Image()).onload = function () {
                        (n.onload = function () {}), (s = { dimensions: { width: n.width, height: n.height } }), (o.image = n), Dimensions.cache.set(e, s.dimensions, o), t.track && Dimensions.loading.clear(e), i && i(s.dimensions, o);
                    }),
                        (n.src = e),
                    t.track && Dimensions.loading.set(e, { image: n, type: a })));
            },
        },
        Sha;
    function detectType(e, t) {
        var i,
            n = (t || detectExtension(e) || "").toLowerCase();
        return (
            $("flash image iframe quicktime".split(" ")).each(function (e, t) {
                -1 < $.inArray(n, Lightview.extensions[t].split(" ")) && (i = t);
            }),
            i || ("#" == e.substr(0, 1) ? "inline" : document.domain && document.domain != e.replace(/(^.*\/\/)|(:.*)|(\/.*)/g, "") ? "iframe" : "image")
        );
    }
    function detectExtension(e) {
        e = (e || "").replace(/\?.*/g, "").match(/\.([^.]{3,4})$/);
        return e ? e[1] : null;
    }
    function deferUntil(e, t) {
        var i = $.extend({ lifetime: 3e5, iteration: 10, fail: null }, arguments[2] || {}),
            n = 0;
        return (
            (e._interval = window.setInterval(
                $.proxy(function () {
                    (n += i.iteration), t() ? (window.clearInterval(e._interval), e()) : n >= i.lifetime && (window.clearInterval(e._interval), i.fail && i.fail());
                }, e),
                i.iteration
            )),
                e._interval
        );
    }
    (Dimensions.Cache = function () {
        return this.initialize.apply(this, _slice.call(arguments));
    }),
        $.extend(Dimensions.Cache.prototype, {
            initialize: function () {
                this.cache = [];
            },
            get: function (e) {
                for (var t = null, i = 0; i < this.cache.length; i++) this.cache[i] && this.cache[i].url == e && (t = this.cache[i]);
                return t;
            },
            set: function (e, t, i) {
                this.remove(e), this.cache.push({ url: e, dimensions: t, data: i });
            },
            remove: function (e) {
                for (var t = 0; t < this.cache.length; t++) this.cache[t] && this.cache[t].url == e && delete this.cache[t];
            },
            inject: function (e) {
                var t = get(e.url);
                t ? $.extend(t, e) : this.cache.push(e);
            },
        }),
        (Dimensions.cache = new Dimensions.Cache()),
        (Dimensions.Loading = function () {
            return this.initialize.apply(this, _slice.call(arguments));
        }),
        $.extend(Dimensions.Loading.prototype, {
            initialize: function () {
                this.cache = [];
            },
            set: function (e, t) {
                this.clear(e), this.cache.push({ url: e, data: t });
            },
            get: function (e) {
                for (var t = null, i = 0; i < this.cache.length; i++) this.cache[i] && this.cache[i].url == e && (t = this.cache[i]);
                return t;
            },
            clear: function (e) {
                for (var t, i = this.cache, n = 0; n < i.length; n++) i[n] && i[n].url == e && i[n].data && ("image" === (t = i[n].data).type && t.image && t.image.onload && (t.image.onload = function () {}), delete i[n]);
            },
        }),
        (Dimensions.loading = new Dimensions.Loading()),
        (Dimensions.preload = function (e, t, i) {
            var n, s;
            "function" == $.type(t) && ((i = t), (t = {})),
            ((t = $.extend({ once: !1 }, t || {})).once && Dimensions.preloaded.get(e)) ||
            ((t = Dimensions.preloaded.get(e)) && t.dimensions
                ? "function" == $.type(i) && i($.extend({}, t.dimensions), t.data)
                : ((n = { url: e, data: { type: "image" } }),
                    (s = new Image()),
                    ((n.data.image = s).onload = function () {
                        (s.onload = function () {}), (n.dimensions = { width: s.width, height: s.height }), "function" == $.type(i) && i(n.dimensions, n.data);
                    }),
                    Dimensions.preloaded.cache.add(n),
                    (s.src = e)));
        }),
        (Dimensions.preloaded = {
            get: function (e) {
                return Dimensions.preloaded.cache.get(e);
            },
            getDimensions: function (e) {
                e = this.get(e);
                return e && e.dimensions;
            },
        }),
        (Dimensions.preloaded.cache =
            ((Sha = []),
                {
                    get: function (e) {
                        for (var t = null, i = 0, n = Sha.length; i < n; i++) Sha[i] && Sha[i].url && Sha[i].url == e && (t = Sha[i]);
                        return t;
                    },
                    add: function (e) {
                        Sha.push(e);
                    },
                })),
        $(document.documentElement).delegate(".lightview[href]", "click", function (e, t) {
            e.stopPropagation(), e.preventDefault();
            t = e.currentTarget;
            Lightview.show(t);
        });
    var Controls = {
        type: !1,
        set: function (e) {
            (this.type = e), Window.States.get("controls_type_changed") && this.hide();
            var i = "lv_button_top_close_controls_type_";
            switch (
                ($("relative top thumbnails".split(" ")).each(function (e, t) {
                    Window.buttonTopClose.removeClass(i + t);
                }),
                    Window.buttonTopClose.addClass(i + e),
                    this.type)
                ) {
                case "relative":
                    this.Relative.show();
                    break;
                case "top":
                    this.Top.show();
                    break;
                case "thumbnails":
                    this.Thumbnails.show();
            }
        },
        refresh: function () {
            this.Relative.Slider.populate(Window.views.length), this.Relative.Slider.setPosition(Window.position), this.Relative.refresh(), (this.Thumbnails.position = Window.position), this.Thumbnails.refresh(), this.Top.refresh();
        },
        hide: function () {
            this.Relative.hide(), this.Top.hide(), this.Thumbnails.hide();
        },
        play: function () {
            this.Relative.play(), this.Top.play();
        },
        stop: function () {
            this.Relative.stop(), this.Top.stop();
        },
        _reset: function () {
            this.Thumbnails._reset();
        },
    };
    function Vka(e) {
        return { width: $(e).innerWidth(), height: $(e).innerHeight() };
    }
    function Wka(e) {
        var t = Vka(e),
            i = e.parentNode;
        return i && $(i).css({ width: t.width + "px" }) && Vka(e).height > t.height && t.width++, $(i).css({ width: "100%" }), t;
    }
    function Zka(e, t, i) {
        var n = t.width - (parseInt($(e).css("padding-left")) || 0) - (parseInt($(e).css("padding-right")) || 0),
            s = (t.height, parseInt($(e).css("padding-top")), parseInt($(e).css("padding-bottom")), Window.options.width);
        return (
            s && "number" == $.type(s) && s < n && ($(e).css({ width: s + "px" }), (t = Wka(e))),
                (t = Window.Dimensions.fit(t, i)),
            /(inline|ajax|html)/.test(i.type) &&
            Window.States.get("resized") &&
            ((n = $("<div>")).css({ position: "absolute", top: 0, left: 0, width: "100%", height: "100%" }),
                $(e).append(n),
                (s = n.innerWidth()),
                $(e).css(px(t)).css({ overflow: "auto" }),
            (s = s - n.innerWidth()) && ((t.width += s), $(e).css(px(t)), (t = Window.Dimensions.fit(t, i))),
                n.remove()),
                t
        );
    }
    (Controls.Thumbnails = {
        create: function () {
            (this.position = -1),
                (this._urls = null),
                (this._skin = null),
                (this._loading_images = []),
                $(document.body)
                    .append(
                        (this.element = $("<div>")
                            .addClass("lv_thumbnails")
                            .append(
                                (this.slider = $("<div>")
                                    .addClass("lv_thumbnails_slider")
                                    .append((this.slide = $("<div>").addClass("lv_thumbnails_slide"))))
                            )
                            .hide())
                    )
                    .append(
                        (this.close = $("<div>")
                            .addClass("lv_controls_top_close")
                            .append((this.close_button = $("<div>").addClass("lv_controls_top_close_button")))
                            .hide())
                    ),
                (this.elements = Window.sideButtonsUnderneath.add(Window.sideButtonsUnderneath.find(".lv_side_left")).add(Window.sideButtonsUnderneath.find(".lv_side_right")).add(Window.innerPreviousNextOverlays)),
            Browser.IE &&
            Browser.IE < 7 &&
            (this.element.css({ position: "absolute", top: "auto" }), this.element[0].style.setExpression("top", "((-1 * this.offsetHeight + (window.jQuery ? jQuery(window).height() + jQuery(window).scrollTop() : 0)) + 'px')")),
                this.startObserving();
        },
        startObserving: function () {
            this.close_button.bind("click", function () {
                Window.hide();
            }),
                this.element
                    .bind(
                        "click",
                        $.proxy(function (e) {
                            (this.options && this.options.overlay && !this.options.overlay.close) || ($(e.target).is(".lv_thumbnails, .lv_thumbnails_slider") && Window.hide());
                        }, this)
                    )
                    .delegate(
                        ".lv_thumbnail_image",
                        "click",
                        $.proxy(function (e) {
                            var i = $(e.target).closest(".lv_thumbnail")[0];
                            this.slide.find(".lv_thumbnail").each(
                                $.proxy(function (e, t) {
                                    e += 1;
                                    t == i && (this.setActive(e), this.setPosition(e), Window.setPosition(e));
                                }, this)
                            );
                        }, this)
                    )
                    .bind(
                        "lightview:mousewheel",
                        $.proxy(function (e, t) {
                            ("thumbnails" != Controls.type || (Window.options && Window.options.controls && Window.options.controls.thumbnails && Window.options.controls.thumbnails.mousewheel)) &&
                            (e.preventDefault(), e.stopPropagation(), this["_" + (-1 == t ? "next" : "previous")]());
                        }, this)
                    ),
                this.close.bind(
                    "lightview:mousewheel",
                    $.proxy(function (e, t) {
                        (!Window.options ||
                            Window.options.mousewheel ||
                            ("thumbnails" == Controls.type && Window.options && Window.options.controls && Window.options.controls.thumbnails && Window.options.controls.thumbnails.mousewheel) ||
                            (Window.options && Window.options.viewport)) &&
                        (e.preventDefault(), e.stopPropagation());
                    }, this)
                );
        },
        setSkin: function (t) {
            $.each(
                { element: "lv_thumbnails_skin_", close: "lv_controls_top_close_skin_" },
                $.proxy(function (e, i) {
                    var n = this[e];
                    $.each((n[0].className || "").split(" "), function (e, t) {
                        -1 < t.indexOf(i) && n.removeClass(t);
                    }),
                        n.addClass(i + t);
                }, this)
            );
            var i = "";
            $.each(Window.views, function (e, t) {
                i += t.url;
            }),
            (this._urls == i && this._skin == t) || this.load(Window.views),
                (this._urls = i),
                (this._skin = t);
        },
        stopLoadingImages: function () {
            $(this._loading_images).each(function (e, t) {
                t.onload = function () {};
            }),
                (this._loading_images = []);
        },
        clear: function () {
            window.Spinners && Spinners.remove(".lv_thumbnail_image .lv_spinner_wrapper"), this.slide.html("");
        },
        _reset: function () {
            (this.position = -1), (this._urls = null);
        },
        load: function (s, e) {
            (this.position = -1),
                this.stopLoadingImages(),
                this.clear(),
                $.each(
                    s,
                    $.proxy(function (e, t) {
                        var i, n;
                        this.slide.append(
                            (i = $("<div>")
                                .addClass("lv_thumbnail")
                                .append((n = $("<div>").addClass("lv_thumbnail_image"))))
                        ),
                            this.slide.css({ width: i.outerWidth() * s.length + "px" }),
                        ("image" == t.type || (t.options.thumbnail && t.options.thumbnail.image)) && (i.addClass("lv_load_thumbnail"), i.data("thumbnail", { view: t, src: (t.options.thumbnail && t.options.thumbnail.image) || t.url })),
                        t.options.thumbnail && t.options.thumbnail.icon && n.append($("<div>").addClass("lv_thumbnail_icon lv_thumbnail_icon_" + t.options.thumbnail.icon));
                    }, this)
                ),
            e && this.moveTo(e, !0);
        },
        _getThumbnailsWithinViewport: function () {
            var e = this.position,
                i = [],
                t = this.slide.find(".lv_thumbnail:first").outerWidth();
            if (!e || !t) return i;
            var n = Bounds.viewport().width,
                t = Math.ceil(n / t),
                s = Math.floor(Math.max(e - 0.5 * t, 0)),
                a = Math.ceil(Math.min(e + 0.5 * t));
            return (
                Window.views && Window.views.length < a && (a = Window.views.length),
                    this.slider.find(".lv_thumbnail").each(function (e, t) {
                        s <= e + 1 && e + 1 <= a && i.push(t);
                    }),
                    i
            );
        },
        loadThumbnailsWithinViewport: function () {
            var e = this._getThumbnailsWithinViewport();
            $(e)
                .filter(".lv_load_thumbnail")
                .each(
                    $.proxy(function (e, t) {
                        var o = $(t).find(".lv_thumbnail_image"),
                            i = $(t).data("thumbnail"),
                            r = i.view;
                        $(t).removeClass("lv_load_thumbnail");
                        var l,
                            d,
                            n,
                            t = r.options.controls;
                        window.Spinners &&
                        (n = t && t.thumbnails && t.thumbnails.spinner) &&
                        (o.append(
                            (d = $("<div>")
                                .addClass("lv_thumbnail_image_spinner_overlay")
                                .append((t = $("<div>").addClass("lv_spinner_wrapper"))))
                        ),
                            (l = Spinners.create(t[0], n || {}).play()),
                            (n = Spinners.getDimensions(t[0])),
                            t.css(px({ height: n.height, width: n.width, "margin-left": Math.ceil(-0.5 * n.width), "margin-top": Math.ceil(-0.5 * n.height) })));
                        var c = { width: o.innerWidth(), height: o.innerHeight() },
                            u = Math.max(c.width, c.height);
                        Dimensions.preload(
                            i.src,
                            { type: r.type },
                            $.proxy(function (e, t) {
                                var i,
                                    n,
                                    s,
                                    a = t.image;
                                a.width > c.width && a.height > c.height
                                    ? ((s = n = 1),
                                    (i = Window.Dimensions.scaleWithin({ width: u, height: u }, e)).width < c.width && (n = c.width / i.width),
                                    i.height < c.height && (s = c.height / i.height),
                                    1 < (s = Math.max(n, s)) && ((i.width *= s), (i.height *= s)),
                                        $.each("width height".split(" "), function (e, t) {
                                            i[t] = Math.round(i[t]);
                                        }))
                                    : (i = Window.Dimensions.scaleWithin(a.width < c.width || a.height < c.height ? { width: u, height: u } : c, e));
                                (a = Math.round(0.5 * c.width - 0.5 * i.width)),
                                    (e = Math.round(0.5 * c.height - 0.5 * i.height)),
                                    (a = $("<img>")
                                        .attr({ src: t.image.src })
                                        .css(px(i))
                                        .css(px({ top: e, left: a })));
                                o.prepend(a),
                                    d
                                        ? d.fadeOut(r.options.effects.thumbnails.load, function () {
                                            l && (l.remove(), (l = null), d.remove());
                                        })
                                        : a.css({ opacity: 0 }).fadeTo(r.options.effects.thumbnails.load, 1);
                            }, this)
                        );
                    }, this)
                );
        },
        show: function () {
            this.elements.add(Window.buttonTopClose).add(this.close).hide();
            var e = this.elements,
                t = Window.options.controls;
            switch (t && t.close) {
                case "top":
                    e = e.add(this.close);
                    break;
                case "relative":
                    e = e.add(Window.buttonTopClose);
            }
            Window.refreshPreviousNext(), e.show(), (Window.views && Window.views.length <= 1) || this.element.stop(1, 0).fadeTo(Window.options.effects.thumbnails.show, 1);
        },
        hide: function () {
            this.elements.add(Window.buttonTopClose).add(this.close).hide(), this.element.stop(1, 0).fadeOut(Window.options.effects.thumbnails.hide);
        },
        _previous: function () {
            var e;
            this.position < 1 || ((e = this.position - 1), this.setActive(e), this.setPosition(e), Window.setPosition(e));
        },
        _next: function () {
            var e;
            this.position + 1 > Window.views.length || ((e = this.position + 1), this.setActive(e), this.setPosition(e), Window.setPosition(e));
        },
        adjustToViewport: function () {
            var e = Bounds.viewport();
            this.slider.css({ width: e.width + "px" });
        },
        setPosition: function (e) {
            var t = this.position < 0;
            e < 1 && (e = 1);
            var i = this.itemCount();
            i < e && (e = i), (this.position = e), this.setActive(e), Window.refreshPreviousNext(), this.moveTo(e, t);
        },
        moveTo: function (e, t) {
            this.adjustToViewport();
            var i = Bounds.viewport().width,
                n = this.slide.find(".lv_thumbnail").outerWidth(),
                n = 0.5 * i + -1 * (n * (e - 1) + 0.5 * n);
            this.slide.stop(1, 0).animate(
                { left: n + "px" },
                t ? 0 : Window.options.effects.thumbnails.slide,
                $.proxy(function () {
                    this.loadThumbnailsWithinViewport();
                }, this)
            );
        },
        setActive: function (e) {
            var t = this.slide.find(".lv_thumbnail").removeClass("lv_thumbnail_active");
            e && $(t[e - 1]).addClass("lv_thumbnail_active");
        },
        refresh: function () {
            this.position && this.setPosition(this.position);
        },
        itemCount: function () {
            return this.slide.find(".lv_thumbnail").length || 0;
        },
    }),
        (Controls.Relative = {
            create: function () {
                this.Slider.create(),
                    (this.elements = $(this.Slider.element)
                        .add(Window.sideButtonsUnderneath)
                        .add(Window.sideButtonsUnderneath.find(".lv_side_left"))
                        .add(Window.sideButtonsUnderneath.find(".lv_side_right"))
                        .add(Window.innerPreviousNextOverlays)
                        .add(Window.innerPreviousNextOverlays.find(".lv_button")));
            },
            show: function () {
                this.hide();
                var e = this.elements,
                    t = Window.options.controls;
                switch (t && t.close) {
                    case "top":
                        e = e.add(Controls.Top.close);
                        break;
                    case "relative":
                        e = e.add(Window.buttonTopClose);
                }
                e.show(), Window.refreshPreviousNext(), ((Window.view && 1 < Window.views.length && Window.mayPrevious()) || Window.mayNext()) && this.Slider.show();
            },
            hide: function () {
                this.elements.add(Controls.Top.close).add(Window.buttonTopClose).hide();
            },
            refresh: function () {
                this.Slider.refresh();
            },
            play: function () {
                this.Slider.play();
            },
            stop: function () {
                this.Slider.stop();
            },
        }),
        (Controls.Relative.Slider = {
            setOptions: function () {
                var e = Window.options,
                    t = (e.controls && e.controls.slider) || {};
                this.options = { items: t.items || 5, duration: (e.effects && e.effects.slider && e.effects.slider.slide) || 100, slideshow: e.slideshow };
            },
            create: function () {
                $(Window.element).append(
                    (this.element = $("<div>")
                        .addClass("lv_controls_relative")
                        .append(
                            (this.slider = $("<div>")
                                .addClass("lv_slider")
                                .append((this.slider_previous = $("<div>").addClass("lv_slider_icon lv_slider_previous").append($("<div>").addClass("lv_icon").data("side", "previous"))))
                                .append(
                                    (this.slider_numbers = $("<div>")
                                        .addClass("lv_slider_numbers")
                                        .append((this.slider_slide = $("<div>").addClass("lv_slider_slide"))))
                                )
                                .append((this.slider_next = $("<div>").addClass("lv_slider_icon lv_slider_next").append($("<div>").addClass("lv_icon").data("side", "next"))))
                                .append((this.slider_slideshow = $("<div>").addClass("lv_slider_icon lv_slider_slideshow").append($("<div>").addClass("lv_icon lv_slider_next")))))
                        ))
                ),
                    this.element.hide(),
                    (this.count = 0),
                    (this.position = 1),
                    (this.page = 1),
                    this.setOptions(),
                    this.startObserving();
            },
            startObserving: function () {
                this.slider_slide.delegate(
                    ".lv_slider_number",
                    "click",
                    $.proxy(function (e) {
                        e.preventDefault(), e.stopPropagation();
                        e = parseInt($(e.target).html());
                        this.setActive(e), Window.stop(), Window.setPosition(e);
                    }, this)
                ),
                    $.each(
                        "previous next".split(" "),
                        $.proxy(function (e, t) {
                            this["slider_" + t].bind("click", $.proxy(this[t + "Page"], this));
                        }, this)
                    ),
                    this.slider.bind(
                        "lightview:mousewheel",
                        $.proxy(function (e, t) {
                            Window.options && Window.options.mousewheel && (this.count <= this.options.items || (e.preventDefault(), e.stopPropagation(), this[(0 < t ? "previous" : "next") + "Page"]()));
                        }, this)
                    ),
                    this.slider_slideshow.bind(
                        "click",
                        $.proxy(function (e) {
                            this.slider_slideshow.hasClass("lv_slider_slideshow_disabled") || Window[Window.States.get("playing") ? "stop" : "play"](!0);
                        }, this)
                    );
            },
            refresh: function () {
                this.setOptions();
                var e,
                    t,
                    i,
                    n = this.itemCount(),
                    s = n <= this.options.items ? n : this.options.items,
                    a = $(Window.element).is(":visible");
                this.element.css({ width: "auto" }),
                    this.slider[1 < n ? "show" : "hide"](),
                n < 2 ||
                (a || $(Window.element).show(),
                    (e = $(document.createElement("div")).addClass("lv_slider_number")),
                    this.slider_slide.append(e),
                    (t = e.outerWidth(!0)),
                    (this.nr_width = t),
                    e.addClass("lv_slider_number_last"),
                    (this.nr_margin_last = t - e.outerWidth(!0) || 0),
                    e.remove(),
                    (s = (n = this.itemCount()) <= this.options.items ? n : this.options.items),
                    (n = (n = this.count % this.options.items) ? this.options.items - n : 0),
                    this.slider_numbers.css({ width: this.nr_width * s - this.nr_margin_last + "px" }),
                    this.slider_slide.css({ width: this.nr_width * (this.count + n) + "px" }),
                    (n =
                        Window.views &&
                        $.grep(Window.views, function (e) {
                            return e.options.slideshow;
                        }).length == Window.views.length),
                    this.slider_slideshow.hide().removeClass("lv_slider_slideshow_disabled"),
                n && this.slider_slideshow.show(),
                this.options.slideshow || this.slider_slideshow.addClass("lv_slider_slideshow_disabled"),
                    this.itemCount() <= this.options.items ? (this.slider_next.hide(), this.slider_previous.hide()) : (this.slider_next.show(), this.slider_previous.show()),
                    this.element.css({ width: "auto" }),
                    this.slider.css({ width: "auto" }),
                    (i = 0),
                    (n = jQuery.map($.makeArray(this.slider.children("div:visible")), function (e, t) {
                        var i = $(e).outerWidth(!0);
                        return Browser.IE && Browser.IE < 7 && (i += (parseInt($(e).css("margin-left")) || 0) + (parseInt($(e).css("margin-right")) || 0)), i;
                    })),
                    $.each(n, function (e, t) {
                        i += t;
                    }),
                Browser.IE && Browser.IE < 7 && i++,
                    this.element.css({ position: "absolute" }),
                i && this.element.css({ width: i + "px" }),
                i && this.slider.css({ width: i + "px" }),
                    this.element.css({ "margin-left": Math.ceil(-0.5 * i) + "px" }),
                parseInt(this.slider_slide.css("left") || 0) < -1 * ((n = this.pageCount()) - 1) * (this.options.items * this.nr_width) && this.scrollToPage(n, !0),
                    this.refreshButtonStates(),
                a || $(Window.element).hide(),
                Window.options && Window.options.controls && !Window.options.controls.slider && this.slider.hide());
            },
            itemCount: function () {
                return this.slider_slide.find(".lv_slider_number").length || 0;
            },
            pageCount: function () {
                return Math.ceil(this.itemCount() / this.options.items);
            },
            setActive: function (e) {
                $(this.slider_numbers.find(".lv_slider_number").removeClass("lv_slider_number_active")[e - 1]).addClass("lv_slider_number_active");
            },
            setPosition: function (e) {
                e < 1 && (e = 1);
                var t = this.itemCount();
                t < e && (e = t), (this.position = e), this.setActive(e), this.scrollToPage(Math.ceil(e / this.options.items));
            },
            refreshButtonStates: function () {
                this.slider_next.removeClass("lv_slider_next_disabled"),
                    this.slider_previous.removeClass("lv_slider_previous_disabled"),
                this.page - 1 < 1 && this.slider_previous.addClass("lv_slider_previous_disabled"),
                this.page >= this.pageCount() && this.slider_next.addClass("lv_slider_next_disabled"),
                    this[Window.States.get("playing") ? "play" : "stop"]();
            },
            scrollToPage: function (e, t) {
                this.page == e ||
                e < 1 ||
                e > this.pageCount() ||
                (Browser.MobileSafari && this.slider_numbers.css({ opacity: 0.999 }),
                    this.slider_slide.stop(!0).animate(
                        { left: this.options.items * this.nr_width * (e - 1) * -1 + "px" },
                        (!t && this.options.duration) || 0,
                        "linear",
                        $.proxy(function () {
                            Browser.MobileSafari && this.slider_numbers.css({ opacity: 1 });
                        }, this)
                    ),
                    (this.page = e),
                    this.refreshButtonStates());
            },
            previousPage: function () {
                this.scrollToPage(this.page - 1);
            },
            nextPage: function () {
                this.scrollToPage(this.page + 1);
            },
            populate: function (e) {
                this.slider_slide.find(".lv_slider_number, .lv_slider_number_empty").remove();
                for (var t = 0; t < e; t++)
                    this.slider_slide.append(
                        $("<div>")
                            .addClass("lv_slider_number")
                            .html(t + 1)
                    );
                for (var i = this.options.items, n = e % i ? i - (e % i) : 0, t = 0; t < n; t++) this.slider_slide.append($("<div>").addClass("lv_slider_number_empty"));
                this.slider_numbers.find(".lv_slider_number, lv_slider_number_empty").removeClass("lv_slider_number_last").last().addClass("lv_slider_number_last"), (this.count = e), this.refresh();
            },
            show: function () {
                this.element.show();
            },
            hide: function () {
                this.element.hide();
            },
            play: function () {
                this.slider_slideshow.addClass("lv_slider_slideshow_playing");
            },
            stop: function () {
                this.slider_slideshow.removeClass("lv_slider_slideshow_playing");
            },
        }),
        (Controls.Top = {
            create: function () {
                var e;
                $(document.body)
                    .append(
                        (this.element = $("<div>")
                            .addClass("lv_controls_top")
                            .append(
                                (this.middle = $("<div>")
                                    .addClass("lv_top_middle")
                                    .hide()
                                    .append(
                                        (this.middle_previous = $("<div>")
                                            .addClass("lv_top_button lv_top_previous")
                                            .data("side", "previous")
                                            .append(
                                                $("<div>")
                                                    .addClass("lv_icon")
                                                    .append((this.text_previous = $("<span>")))
                                            ))
                                    )
                                    .append((this.middle_slideshow = $("<div>").addClass("lv_top_button lv_top_slideshow").append($("<div>").addClass("lv_icon"))))
                                    .append(
                                        (this.middle_next = $("<div>")
                                            .addClass("lv_top_button lv_top_next")
                                            .data("side", "next")
                                            .append(
                                                $("<div>")
                                                    .addClass("lv_icon")
                                                    .append((this.text_next = $("<span>")))
                                            ))
                                    ))
                            )
                            .hide())
                    )
                    .append(
                        (this.close = $("<div>")
                            .addClass("lv_controls_top_close")
                            .append((this.close_button = $("<div>").addClass("lv_controls_top_close_button")))
                            .hide())
                    ),
                Browser.IE &&
                Browser.IE < 7 &&
                (((e = this.element[0].style).position = "absolute"),
                    e.setExpression("top", '((!!window.jQuery && jQuery(window).scrollTop()) || 0) + "px"'),
                    ((e = this.close[0].style).position = "absolute"),
                    e.setExpression("top", '((!!window.jQuery && jQuery(window).scrollTop()) || 0) + "px"')),
                    this.setOptions(),
                    this.startObserving();
            },
            setOptions: function (e) {
                (this.options = $.extend({ slideshow: !0, text: { previous: "Prev", next: "Next" }, close: !0 }, (Window.options && Window.options.controls) || {})), this.setText();
            },
            setSkin: function (t) {
                $.each(
                    { element: "lv_controls_top_skin_", close: "lv_controls_top_close_skin_" },
                    $.proxy(function (e, i) {
                        var n = this[e];
                        $.each((n[0].className || "").split(" "), function (e, t) {
                            -1 < t.indexOf(i) && n.removeClass(t);
                        }),
                            n.addClass(i + t);
                    }, this)
                );
            },
            setText: function () {
                this.text_previous.hide(), this.text_next.hide(), this.options.text && (this.text_previous.html(this.options.text.previous).show(), this.text_next.html(this.options.text.next).show());
            },
            startObserving: function () {
                this.middle_previous.bind("click", function () {
                    Window.stop(), Window.previous(), $(this).blur();
                }),
                    this.middle_slideshow.bind("click", function () {
                        0 < $(this).find(".lv_icon_disabled").length || Window[Window.States.get("playing") ? "stop" : "play"](!0);
                    }),
                    this.middle_next.bind("click", function () {
                        Window.stop(), Window.next(), $(this).blur();
                    }),
                    this.close_button.bind("click", function () {
                        Window.hide();
                    }),
                    this.element.add(this.close).bind(
                        "lightview:mousewheel",
                        $.proxy(function (e, t) {
                            (!Window.options || !Window.options.mousewheel || (Window.options && Window.options.viewport)) && (e.preventDefault(), e.stopPropagation());
                        }, this)
                    );
            },
            show: function () {
                var e = this.element,
                    t = Window.options.controls;
                switch (t && t.close) {
                    case "top":
                        e = e.add(this.close);
                        break;
                    case "relative":
                        e = e.add(Window.buttonTopClose);
                }
                e.show();
            },
            hide: function () {
                this.element.hide(), this.close.hide();
            },
            refresh: function () {
                this.setOptions(),
                    this.element.find(".lv_icon_disabled").removeClass("lv_icon_disabled"),
                Window.mayPrevious() || this.middle_previous.find(".lv_icon").addClass("lv_icon_disabled"),
                Window.options.slideshow || this.middle_slideshow.find(".lv_icon").addClass("lv_icon_disabled"),
                Window.mayNext() || this.middle_next.find(".lv_icon").addClass("lv_icon_disabled"),
                    this.element.removeClass("lv_controls_top_with_slideshow"),
                Window.views &&
                0 <
                $.grep(Window.views, function (e) {
                    return e.options.slideshow;
                }).length &&
                this.element.addClass("lv_controls_top_with_slideshow"),
                    this.element["top" == Controls.type && 1 < Window.views.length ? "show" : "hide"](),
                    this[Window.States.get("playing") ? "play" : "stop"]();
            },
            play: function () {
                this.middle_slideshow.addClass("lv_top_slideshow_playing");
            },
            stop: function () {
                this.middle_slideshow.removeClass("lv_top_slideshow_playing");
            },
        }),
        (Window.updateQueue = {
            build: function () {
                $(document.body).append(
                    $(document.createElement("div"))
                        .addClass("lv_update_queue")
                        .append(
                            $("<div>")
                                .addClass("lv_window")
                                .append((this.container = $("<div>").addClass("lv_content")))
                        )
                );
            },
            update: function (e, o, r) {
                this.container || this.build(),
                    $.extend({ spinner: !1 }, arguments[3] || {}),
                (o.options.inline || _.isElement(e)) &&
                (o.options.inline && "string" == $.type(e) && (e = $("#" + e)[0]),
                !Window.inlineMarker &&
                e &&
                _.element.isAttached(e) &&
                ($(e).data("lv_restore_inline_display", $(e).css("display")), (Window.inlineMarker = document.createElement("div")), $(e).before($(Window.inlineMarker).hide())));
                var l = document.createElement("div");
                this.container.append($(l).addClass("lv_content_wrapper").append(e)),
                _.isElement(e) && $(e).show(),
                o.options.wrapperClass && $(l).addClass(o.options.wrapperClass),
                o.options.skin && $(l).addClass("lv_content_" + o.options.skin);
                var d,
                    c,
                    t,
                    u = $(l)
                        .find("img[src]")
                        .filter(function () {
                            return !($(this).attr("height") && $(this).attr("width"));
                        });
                0 < u.length
                    ? (Window.States.set("preloading_images", !0),
                        (d = 0),
                        (c = o.url),
                        (t = Math.max(8e3, 750 * (u.length || 0))),
                        Window.Timeouts.clear("preloading_images"),
                        Window.Timeouts.set(
                            "preloading_images",
                            $.proxy(function () {
                                u.each(function () {
                                    this.onload = function () {};
                                }),
                                d >= u.length || (Window.view && Window.view.url != c) || this._update(l, o, r);
                            }, this),
                            t
                        ),
                        Window.States.set("preloading_images", u),
                        $.each(
                            u,
                            $.proxy(function (e, s) {
                                var a = new Image();
                                (a.onload = $.proxy(function () {
                                    a.onload = function () {};
                                    var e = a.width,
                                        t = a.height,
                                        i = $(s).attr("width"),
                                        n = $(s).attr("height");
                                    (i && n) || (!i && n ? ((e = Math.round((n * e) / t)), (t = n)) : !n && i && ((t = Math.round((i * t) / e)), (e = i)), $(s).attr({ width: e, height: t })),
                                    ++d == u.length && (Window.Timeouts.clear("preloading_images"), Window.States.set("preloading_images", !1), (Window.view && Window.view.url != c) || this._update(l, o, r));
                                }, this)),
                                    (a.src = s.src);
                            }, this)
                        ))
                    : this._update(l, o, r);
            },
            _update: function (e, t, i) {
                var n = Wka(e),
                    n = Zka(e, n, t);
                Window.resizeTo(n.width, n.height, {
                    complete: function () {
                        Window.content.html(e), i && i();
                    },
                });
            },
            getFittedDimensions: Zka,
            getMeasureElementDimensions: Wka,
        }),
        $.extend(
            !0,
            Lightview,
            (function () {
                function show(object) {
                    var options = arguments[1] || {},
                        position = arguments[2];
                    arguments[1] && "number" == $.type(arguments[1]) && ((position = arguments[1]), (options = Options.create({})));
                    var views = [],
                        object_type;
                    switch ((object_type = $.type(object))) {
                        case "string":
                        case "object":
                            var view = new View(object, options),
                                elements,
                                groupOptions,
                                groupOptions;
                            view.group
                                ? object &&
                                1 == object.nodeType &&
                                ((elements = $('.lightview[data-lightview-group="' + $(object).data("lightview-group") + '"]')),
                                    (groupOptions = {}),
                                    elements.filter("[data-lightview-group-options]").each(function (i, element) {
                                        $.extend(groupOptions, eval("({" + ($(element).attr("data-lightview-group-options") || "") + "})"));
                                    }),
                                    elements.each(function (e, t) {
                                        position || t != object || (position = e + 1), views.push(new View(t, $.extend({}, groupOptions, options)));
                                    }))
                                : ((groupOptions = {}),
                                object &&
                                1 == object.nodeType &&
                                $(object).is("[data-lightview-group-options]") &&
                                ($.extend(groupOptions, eval("({" + ($(object).attr("data-lightview-group-options") || "") + "})")), (view = new View(object, $.extend({}, groupOptions, options)))),
                                    views.push(view));
                            break;
                        case "array":
                            $.each(object, function (e, t) {
                                t = new View(t, options);
                                views.push(t);
                            });
                    }
                    (!position || position < 1) && (position = 1),
                    position > views.length && (position = views.length),
                        Window.load(views, position, { initialDimensionsOnly: !0 }),
                        Window.show(function () {
                            Window.setPosition(position);
                        });
                }
                function refresh() {
                    return Window.refresh(), this;
                }
                function setDefaultSkin(e) {
                    return Window.setDefaultSkin(e), this;
                }
                function hide() {
                    return Window.hide(), this;
                }
                function play(e) {
                    return Window.play(e), this;
                }
                function stop() {
                    return Window.stop(), this;
                }
                return { show: show, hide: hide, play: play, stop: stop, refresh: refresh, setDefaultSkin: setDefaultSkin };
            })()
        ),
        (window.Lightview = Lightview),
        $(document).ready(function () {
            Lightview.init();
        });
})(jQuery, window),
    (function (e) {
        "use strict";
        "function" == typeof define && define.amd ? define(["jquery"], e) : "undefined" != typeof exports ? (module.exports = e(require("jquery"))) : e(jQuery);
    })(function (d) {
        "use strict";
        var n,
            a = window.Slick || {};
        (n = 0),
            ((a = function (e, t) {
                var i = this;
                (i.defaults = {
                    accessibility: !0,
                    adaptiveHeight: !1,
                    appendArrows: d(e),
                    appendDots: d(e),
                    arrows: !0,
                    asNavFor: null,
                    prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
                    nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>',
                    autoplay: !1,
                    autoplaySpeed: 3e3,
                    centerMode: !1,
                    centerPadding: "50px",
                    cssEase: "ease",
                    customPaging: function (e, t) {
                        return d('<button type="button" />').text(t + 1);
                    },
                    dots: !1,
                    dotsClass: "slick-dots",
                    draggable: !0,
                    easing: "linear",
                    edgeFriction: 0.35,
                    fade: !1,
                    focusOnSelect: !1,
                    focusOnChange: !1,
                    infinite: !0,
                    initialSlide: 0,
                    lazyLoad: "ondemand",
                    mobileFirst: !1,
                    pauseOnHover: !0,
                    pauseOnFocus: !0,
                    pauseOnDotsHover: !1,
                    respondTo: "window",
                    responsive: null,
                    rows: 1,
                    rtl: !1,
                    slide: "",
                    slidesPerRow: 1,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    speed: 500,
                    swipe: !0,
                    swipeToSlide: !1,
                    touchMove: !0,
                    touchThreshold: 5,
                    useCSS: !0,
                    useTransform: !0,
                    variableWidth: !1,
                    vertical: !1,
                    verticalSwiping: !1,
                    waitForAnimate: !0,
                    zIndex: 1e3,
                }),
                    (i.initials = {
                        animating: !1,
                        dragging: !1,
                        autoPlayTimer: null,
                        currentDirection: 0,
                        currentLeft: null,
                        currentSlide: 0,
                        direction: 1,
                        $dots: null,
                        listWidth: null,
                        listHeight: null,
                        loadIndex: 0,
                        $nextArrow: null,
                        $prevArrow: null,
                        scrolling: !1,
                        slideCount: null,
                        slideWidth: null,
                        $slideTrack: null,
                        $slides: null,
                        sliding: !1,
                        slideOffset: 0,
                        swipeLeft: null,
                        swiping: !1,
                        $list: null,
                        touchObject: {},
                        transformsEnabled: !1,
                        unslicked: !1,
                    }),
                    d.extend(i, i.initials),
                    (i.activeBreakpoint = null),
                    (i.animType = null),
                    (i.animProp = null),
                    (i.breakpoints = []),
                    (i.breakpointSettings = []),
                    (i.cssTransitions = !1),
                    (i.focussed = !1),
                    (i.interrupted = !1),
                    (i.hidden = "hidden"),
                    (i.paused = !0),
                    (i.positionProp = null),
                    (i.respondTo = null),
                    (i.rowCount = 1),
                    (i.shouldClick = !0),
                    (i.$slider = d(e)),
                    (i.$slidesCache = null),
                    (i.transformType = null),
                    (i.transitionType = null),
                    (i.visibilityChange = "visibilitychange"),
                    (i.windowWidth = 0),
                    (i.windowTimer = null),
                    (e = d(e).data("slick") || {}),
                    (i.options = d.extend({}, i.defaults, t, e)),
                    (i.currentSlide = i.options.initialSlide),
                    (i.originalSettings = i.options),
                    void 0 !== document.mozHidden
                        ? ((i.hidden = "mozHidden"), (i.visibilityChange = "mozvisibilitychange"))
                        : void 0 !== document.webkitHidden && ((i.hidden = "webkitHidden"), (i.visibilityChange = "webkitvisibilitychange")),
                    (i.autoPlay = d.proxy(i.autoPlay, i)),
                    (i.autoPlayClear = d.proxy(i.autoPlayClear, i)),
                    (i.autoPlayIterator = d.proxy(i.autoPlayIterator, i)),
                    (i.changeSlide = d.proxy(i.changeSlide, i)),
                    (i.clickHandler = d.proxy(i.clickHandler, i)),
                    (i.selectHandler = d.proxy(i.selectHandler, i)),
                    (i.setPosition = d.proxy(i.setPosition, i)),
                    (i.swipeHandler = d.proxy(i.swipeHandler, i)),
                    (i.dragHandler = d.proxy(i.dragHandler, i)),
                    (i.keyHandler = d.proxy(i.keyHandler, i)),
                    (i.instanceUid = n++),
                    (i.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/),
                    i.registerBreakpoints(),
                    i.init(!0);
            }).prototype.activateADA = function () {
                this.$slideTrack.find(".slick-active").attr({ "aria-hidden": "false" }).find("a, input, button, select").attr({ tabindex: "0" });
            }),
            (a.prototype.addSlide = a.prototype.slickAdd = function (e, t, i) {
                var n = this;
                if ("boolean" == typeof t) (i = t), (t = null);
                else if (t < 0 || t >= n.slideCount) return !1;
                n.unload(),
                    "number" == typeof t
                        ? 0 === t && 0 === n.$slides.length
                            ? d(e).appendTo(n.$slideTrack)
                            : i
                                ? d(e).insertBefore(n.$slides.eq(t))
                                : d(e).insertAfter(n.$slides.eq(t))
                        : !0 === i
                            ? d(e).prependTo(n.$slideTrack)
                            : d(e).appendTo(n.$slideTrack),
                    (n.$slides = n.$slideTrack.children(this.options.slide)),
                    n.$slideTrack.children(this.options.slide).detach(),
                    n.$slideTrack.append(n.$slides),
                    n.$slides.each(function (e, t) {
                        d(t).attr("data-slick-index", e);
                    }),
                    (n.$slidesCache = n.$slides),
                    n.reinit();
            }),
            (a.prototype.animateHeight = function () {
                var e;
                1 === this.options.slidesToShow && !0 === this.options.adaptiveHeight && !1 === this.options.vertical && ((e = this.$slides.eq(this.currentSlide).outerHeight(!0)), this.$list.animate({ height: e }, this.options.speed));
            }),
            (a.prototype.animateSlide = function (e, t) {
                var i = {},
                    n = this;
                n.animateHeight(),
                !0 === n.options.rtl && !1 === n.options.vertical && (e = -e),
                    !1 === n.transformsEnabled
                        ? !1 === n.options.vertical
                            ? n.$slideTrack.animate({ left: e }, n.options.speed, n.options.easing, t)
                            : n.$slideTrack.animate({ top: e }, n.options.speed, n.options.easing, t)
                        : !1 === n.cssTransitions
                            ? (!0 === n.options.rtl && (n.currentLeft = -n.currentLeft),
                                d({ animStart: n.currentLeft }).animate(
                                    { animStart: e },
                                    {
                                        duration: n.options.speed,
                                        easing: n.options.easing,
                                        step: function (e) {
                                            (e = Math.ceil(e)), !1 === n.options.vertical ? (i[n.animType] = "translate(" + e + "px, 0px)") : (i[n.animType] = "translate(0px," + e + "px)"), n.$slideTrack.css(i);
                                        },
                                        complete: function () {
                                            t && t.call();
                                        },
                                    }
                                ))
                            : (n.applyTransition(),
                                (e = Math.ceil(e)),
                                !1 === n.options.vertical ? (i[n.animType] = "translate3d(" + e + "px, 0px, 0px)") : (i[n.animType] = "translate3d(0px," + e + "px, 0px)"),
                                n.$slideTrack.css(i),
                            t &&
                            setTimeout(function () {
                                n.disableTransition(), t.call();
                            }, n.options.speed));
            }),
            (a.prototype.getNavTarget = function () {
                var e = this.options.asNavFor;
                return e && null !== e && (e = d(e).not(this.$slider)), e;
            }),
            (a.prototype.asNavFor = function (t) {
                var e = this.getNavTarget();
                null !== e &&
                "object" == typeof e &&
                e.each(function () {
                    var e = d(this).slick("getSlick");
                    e.unslicked || e.slideHandler(t, !0);
                });
            }),
            (a.prototype.applyTransition = function (e) {
                var t = this,
                    i = {};
                !1 === t.options.fade ? (i[t.transitionType] = t.transformType + " " + t.options.speed + "ms " + t.options.cssEase) : (i[t.transitionType] = "opacity " + t.options.speed + "ms " + t.options.cssEase),
                    (!1 === t.options.fade ? t.$slideTrack : t.$slides.eq(e)).css(i);
            }),
            (a.prototype.autoPlay = function () {
                this.autoPlayClear(), this.slideCount > this.options.slidesToShow && (this.autoPlayTimer = setInterval(this.autoPlayIterator, this.options.autoplaySpeed));
            }),
            (a.prototype.autoPlayClear = function () {
                this.autoPlayTimer && clearInterval(this.autoPlayTimer);
            }),
            (a.prototype.autoPlayIterator = function () {
                var e = this,
                    t = e.currentSlide + e.options.slidesToScroll;
                e.paused ||
                e.interrupted ||
                e.focussed ||
                (!1 === e.options.infinite &&
                (1 === e.direction && e.currentSlide + 1 === e.slideCount - 1 ? (e.direction = 0) : 0 === e.direction && ((t = e.currentSlide - e.options.slidesToScroll), e.currentSlide - 1 == 0 && (e.direction = 1))),
                    e.slideHandler(t));
            }),
            (a.prototype.buildArrows = function () {
                var e = this;
                !0 === e.options.arrows &&
                ((e.$prevArrow = d(e.options.prevArrow).addClass("slick-arrow")),
                    (e.$nextArrow = d(e.options.nextArrow).addClass("slick-arrow")),
                    e.slideCount > e.options.slidesToShow
                        ? (e.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"),
                            e.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"),
                        e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.prependTo(e.options.appendArrows),
                        e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.appendTo(e.options.appendArrows),
                        !0 !== e.options.infinite && e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"))
                        : e.$prevArrow.add(e.$nextArrow).addClass("slick-hidden").attr({ "aria-disabled": "true", tabindex: "-1" }));
            }),
            (a.prototype.buildDots = function () {
                var e, t;
                if (!0 === this.options.dots) {
                    for (this.$slider.addClass("slick-dotted"), t = d("<ul />").addClass(this.options.dotsClass), e = 0; e <= this.getDotCount(); e += 1) t.append(d("<li />").append(this.options.customPaging.call(this, this, e)));
                    (this.$dots = t.appendTo(this.options.appendDots)), this.$dots.find("li").first().addClass("slick-active");
                }
            }),
            (a.prototype.buildOut = function () {
                var e = this;
                (e.$slides = e.$slider.children(e.options.slide + ":not(.slick-cloned)").addClass("slick-slide")),
                    (e.slideCount = e.$slides.length),
                    e.$slides.each(function (e, t) {
                        d(t)
                            .attr("data-slick-index", e)
                            .data("originalStyling", d(t).attr("style") || "");
                    }),
                    e.$slider.addClass("slick-slider"),
                    (e.$slideTrack = 0 === e.slideCount ? d('<div class="slick-track"/>').appendTo(e.$slider) : e.$slides.wrapAll('<div class="slick-track"/>').parent()),
                    (e.$list = e.$slideTrack.wrap('<div class="slick-list"/>').parent()),
                    e.$slideTrack.css("opacity", 0),
                (!0 !== e.options.centerMode && !0 !== e.options.swipeToSlide) || (e.options.slidesToScroll = 1),
                    d("img[data-lazy]", e.$slider).not("[src]").addClass("slick-loading"),
                    e.setupInfinite(),
                    e.buildArrows(),
                    e.buildDots(),
                    e.updateDots(),
                    e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0),
                !0 === e.options.draggable && e.$list.addClass("draggable");
            }),
            (a.prototype.buildRows = function () {
                var e,
                    t,
                    i,
                    n = this,
                    s = document.createDocumentFragment(),
                    a = n.$slider.children();
                if (1 < n.options.rows) {
                    for (i = n.options.slidesPerRow * n.options.rows, t = Math.ceil(a.length / i), e = 0; e < t; e++) {
                        for (var o = document.createElement("div"), r = 0; r < n.options.rows; r++) {
                            for (var l = document.createElement("div"), d = 0; d < n.options.slidesPerRow; d++) {
                                var c = e * i + (r * n.options.slidesPerRow + d);
                                a.get(c) && l.appendChild(a.get(c));
                            }
                            o.appendChild(l);
                        }
                        s.appendChild(o);
                    }
                    n.$slider.empty().append(s),
                        n.$slider
                            .children()
                            .children()
                            .children()
                            .css({ width: 100 / n.options.slidesPerRow + "%", display: "inline-block" });
                }
            }),
            (a.prototype.checkResponsive = function (e, t) {
                var i,
                    n,
                    s,
                    a = this,
                    o = !1,
                    r = a.$slider.width(),
                    l = window.innerWidth || d(window).width();
                if (("window" === a.respondTo ? (s = l) : "slider" === a.respondTo ? (s = r) : "min" === a.respondTo && (s = Math.min(l, r)), a.options.responsive && a.options.responsive.length && null !== a.options.responsive)) {
                    for (i in ((n = null), a.breakpoints)) a.breakpoints.hasOwnProperty(i) && (!1 === a.originalSettings.mobileFirst ? s < a.breakpoints[i] && (n = a.breakpoints[i]) : s > a.breakpoints[i] && (n = a.breakpoints[i]));
                    null !== n
                        ? (null !== a.activeBreakpoint && n === a.activeBreakpoint && !t) ||
                        ((a.activeBreakpoint = n),
                            "unslick" === a.breakpointSettings[n] ? a.unslick(n) : ((a.options = d.extend({}, a.originalSettings, a.breakpointSettings[n])), !0 === e && (a.currentSlide = a.options.initialSlide), a.refresh(e)),
                            (o = n))
                        : null !== a.activeBreakpoint && ((a.activeBreakpoint = null), (a.options = a.originalSettings), !0 === e && (a.currentSlide = a.options.initialSlide), a.refresh(e), (o = n)),
                    e || !1 === o || a.$slider.trigger("breakpoint", [a, o]);
                }
            }),
            (a.prototype.changeSlide = function (e, t) {
                var i,
                    n = this,
                    s = d(e.currentTarget);
                switch ((s.is("a") && e.preventDefault(), s.is("li") || (s = s.closest("li")), (i = n.slideCount % n.options.slidesToScroll != 0 ? 0 : (n.slideCount - n.currentSlide) % n.options.slidesToScroll), e.data.message)) {
                    case "previous":
                        (a = 0 == i ? n.options.slidesToScroll : n.options.slidesToShow - i), n.slideCount > n.options.slidesToShow && n.slideHandler(n.currentSlide - a, !1, t);
                        break;
                    case "next":
                        (a = 0 == i ? n.options.slidesToScroll : i), n.slideCount > n.options.slidesToShow && n.slideHandler(n.currentSlide + a, !1, t);
                        break;
                    case "index":
                        var a = 0 === e.data.index ? 0 : e.data.index || s.index() * n.options.slidesToScroll;
                        n.slideHandler(n.checkNavigable(a), !1, t), s.children().trigger("focus");
                        break;
                    default:
                        return;
                }
            }),
            (a.prototype.checkNavigable = function (e) {
                var t = this.getNavigableIndexes(),
                    i = 0;
                if (e > t[t.length - 1]) e = t[t.length - 1];
                else
                    for (var n in t) {
                        if (e < t[n]) {
                            e = i;
                            break;
                        }
                        i = t[n];
                    }
                return e;
            }),
            (a.prototype.cleanUpEvents = function () {
                var e = this;
                e.options.dots &&
                null !== e.$dots &&
                (d("li", e.$dots).off("click.slick", e.changeSlide).off("mouseenter.slick", d.proxy(e.interrupt, e, !0)).off("mouseleave.slick", d.proxy(e.interrupt, e, !1)),
                !0 === e.options.accessibility && e.$dots.off("keydown.slick", e.keyHandler)),
                    e.$slider.off("focus.slick blur.slick"),
                !0 === e.options.arrows &&
                e.slideCount > e.options.slidesToShow &&
                (e.$prevArrow && e.$prevArrow.off("click.slick", e.changeSlide),
                e.$nextArrow && e.$nextArrow.off("click.slick", e.changeSlide),
                !0 === e.options.accessibility && (e.$prevArrow && e.$prevArrow.off("keydown.slick", e.keyHandler), e.$nextArrow && e.$nextArrow.off("keydown.slick", e.keyHandler))),
                    e.$list.off("touchstart.slick mousedown.slick", e.swipeHandler),
                    e.$list.off("touchmove.slick mousemove.slick", e.swipeHandler),
                    e.$list.off("touchend.slick mouseup.slick", e.swipeHandler),
                    e.$list.off("touchcancel.slick mouseleave.slick", e.swipeHandler),
                    e.$list.off("click.slick", e.clickHandler),
                    d(document).off(e.visibilityChange, e.visibility),
                    e.cleanUpSlideEvents(),
                !0 === e.options.accessibility && e.$list.off("keydown.slick", e.keyHandler),
                !0 === e.options.focusOnSelect && d(e.$slideTrack).children().off("click.slick", e.selectHandler),
                    d(window).off("orientationchange.slick.slick-" + e.instanceUid, e.orientationChange),
                    d(window).off("resize.slick.slick-" + e.instanceUid, e.resize),
                    d("[draggable!=true]", e.$slideTrack).off("dragstart", e.preventDefault),
                    d(window).off("load.slick.slick-" + e.instanceUid, e.setPosition);
            }),
            (a.prototype.cleanUpSlideEvents = function () {
                this.$list.off("mouseenter.slick", d.proxy(this.interrupt, this, !0)), this.$list.off("mouseleave.slick", d.proxy(this.interrupt, this, !1));
            }),
            (a.prototype.cleanUpRows = function () {
                var e;
                1 < this.options.rows && ((e = this.$slides.children().children()).removeAttr("style"), this.$slider.empty().append(e));
            }),
            (a.prototype.clickHandler = function (e) {
                !1 === this.shouldClick && (e.stopImmediatePropagation(), e.stopPropagation(), e.preventDefault());
            }),
            (a.prototype.destroy = function (e) {
                var t = this;
                t.autoPlayClear(),
                    (t.touchObject = {}),
                    t.cleanUpEvents(),
                    d(".slick-cloned", t.$slider).detach(),
                t.$dots && t.$dots.remove(),
                t.$prevArrow &&
                t.$prevArrow.length &&
                (t.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.remove()),
                t.$nextArrow &&
                t.$nextArrow.length &&
                (t.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.remove()),
                t.$slides &&
                (t.$slides
                    .removeClass("slick-slide slick-active slick-center slick-visible slick-current")
                    .removeAttr("aria-hidden")
                    .removeAttr("data-slick-index")
                    .each(function () {
                        d(this).attr("style", d(this).data("originalStyling"));
                    }),
                    t.$slideTrack.children(this.options.slide).detach(),
                    t.$slideTrack.detach(),
                    t.$list.detach(),
                    t.$slider.append(t.$slides)),
                    t.cleanUpRows(),
                    t.$slider.removeClass("slick-slider"),
                    t.$slider.removeClass("slick-initialized"),
                    t.$slider.removeClass("slick-dotted"),
                    (t.unslicked = !0),
                e || t.$slider.trigger("destroy", [t]);
            }),
            (a.prototype.disableTransition = function (e) {
                var t = {};
                (t[this.transitionType] = ""), (!1 === this.options.fade ? this.$slideTrack : this.$slides.eq(e)).css(t);
            }),
            (a.prototype.fadeSlide = function (e, t) {
                var i = this;
                !1 === i.cssTransitions
                    ? (i.$slides.eq(e).css({ zIndex: i.options.zIndex }), i.$slides.eq(e).animate({ opacity: 1 }, i.options.speed, i.options.easing, t))
                    : (i.applyTransition(e),
                        i.$slides.eq(e).css({ opacity: 1, zIndex: i.options.zIndex }),
                    t &&
                    setTimeout(function () {
                        i.disableTransition(e), t.call();
                    }, i.options.speed));
            }),
            (a.prototype.fadeSlideOut = function (e) {
                !1 === this.cssTransitions
                    ? this.$slides.eq(e).animate({ opacity: 0, zIndex: this.options.zIndex - 2 }, this.options.speed, this.options.easing)
                    : (this.applyTransition(e), this.$slides.eq(e).css({ opacity: 0, zIndex: this.options.zIndex - 2 }));
            }),
            (a.prototype.filterSlides = a.prototype.slickFilter = function (e) {
                null !== e && ((this.$slidesCache = this.$slides), this.unload(), this.$slideTrack.children(this.options.slide).detach(), this.$slidesCache.filter(e).appendTo(this.$slideTrack), this.reinit());
            }),
            (a.prototype.focusHandler = function () {
                var i = this;
                i.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick", "*", function (e) {
                    e.stopImmediatePropagation();
                    var t = d(this);
                    setTimeout(function () {
                        i.options.pauseOnFocus && ((i.focussed = t.is(":focus")), i.autoPlay());
                    }, 0);
                });
            }),
            (a.prototype.getCurrent = a.prototype.slickCurrentSlide = function () {
                return this.currentSlide;
            }),
            (a.prototype.getDotCount = function () {
                var e = this,
                    t = 0,
                    i = 0,
                    n = 0;
                if (!0 === e.options.infinite)
                    if (e.slideCount <= e.options.slidesToShow) ++n;
                    else for (; t < e.slideCount; ) ++n, (t = i + e.options.slidesToScroll), (i += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow);
                else if (!0 === e.options.centerMode) n = e.slideCount;
                else if (e.options.asNavFor) for (; t < e.slideCount; ) ++n, (t = i + e.options.slidesToScroll), (i += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow);
                else n = 1 + Math.ceil((e.slideCount - e.options.slidesToShow) / e.options.slidesToScroll);
                return n - 1;
            }),
            (a.prototype.getLeft = function (e) {
                var t,
                    i,
                    n = this,
                    s = 0;
                return (
                    (n.slideOffset = 0),
                        (t = n.$slides.first().outerHeight(!0)),
                        !0 === n.options.infinite
                            ? (n.slideCount > n.options.slidesToShow &&
                            ((n.slideOffset = n.slideWidth * n.options.slidesToShow * -1),
                                (i = -1),
                            !0 === n.options.vertical && !0 === n.options.centerMode && (2 === n.options.slidesToShow ? (i = -1.5) : 1 === n.options.slidesToShow && (i = -2)),
                                (s = t * n.options.slidesToShow * i)),
                            n.slideCount % n.options.slidesToScroll != 0 &&
                            e + n.options.slidesToScroll > n.slideCount &&
                            n.slideCount > n.options.slidesToShow &&
                            (s =
                                e > n.slideCount
                                    ? ((n.slideOffset = (n.options.slidesToShow - (e - n.slideCount)) * n.slideWidth * -1), (n.options.slidesToShow - (e - n.slideCount)) * t * -1)
                                    : ((n.slideOffset = (n.slideCount % n.options.slidesToScroll) * n.slideWidth * -1), (n.slideCount % n.options.slidesToScroll) * t * -1)))
                            : e + n.options.slidesToShow > n.slideCount && ((n.slideOffset = (e + n.options.slidesToShow - n.slideCount) * n.slideWidth), (s = (e + n.options.slidesToShow - n.slideCount) * t)),
                    n.slideCount <= n.options.slidesToShow && (s = n.slideOffset = 0),
                        !0 === n.options.centerMode && n.slideCount <= n.options.slidesToShow
                            ? (n.slideOffset = (n.slideWidth * Math.floor(n.options.slidesToShow)) / 2 - (n.slideWidth * n.slideCount) / 2)
                            : !0 === n.options.centerMode && !0 === n.options.infinite
                                ? (n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2) - n.slideWidth)
                                : !0 === n.options.centerMode && ((n.slideOffset = 0), (n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2))),
                        (t = !1 === n.options.vertical ? e * n.slideWidth * -1 + n.slideOffset : e * t * -1 + s),
                    !0 === n.options.variableWidth &&
                    ((s = n.slideCount <= n.options.slidesToShow || !1 === n.options.infinite ? n.$slideTrack.children(".slick-slide").eq(e) : n.$slideTrack.children(".slick-slide").eq(e + n.options.slidesToShow)),
                        (t = !0 === n.options.rtl ? (s[0] ? -1 * (n.$slideTrack.width() - s[0].offsetLeft - s.width()) : 0) : s[0] ? -1 * s[0].offsetLeft : 0),
                    !0 === n.options.centerMode &&
                    ((s = n.slideCount <= n.options.slidesToShow || !1 === n.options.infinite ? n.$slideTrack.children(".slick-slide").eq(e) : n.$slideTrack.children(".slick-slide").eq(e + n.options.slidesToShow + 1)),
                        (t = !0 === n.options.rtl ? (s[0] ? -1 * (n.$slideTrack.width() - s[0].offsetLeft - s.width()) : 0) : s[0] ? -1 * s[0].offsetLeft : 0),
                        (t += (n.$list.width() - s.outerWidth()) / 2))),
                        t
                );
            }),
            (a.prototype.getOption = a.prototype.slickGetOption = function (e) {
                return this.options[e];
            }),
            (a.prototype.getNavigableIndexes = function () {
                for (var e = this, t = 0, i = 0, n = [], s = !1 === e.options.infinite ? e.slideCount : ((t = -1 * e.options.slidesToScroll), (i = -1 * e.options.slidesToScroll), 2 * e.slideCount); t < s; )
                    n.push(t), (t = i + e.options.slidesToScroll), (i += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow);
                return n;
            }),
            (a.prototype.getSlick = function () {
                return this;
            }),
            (a.prototype.getSlideCount = function () {
                var i,
                    n = this,
                    s = !0 === n.options.centerMode ? n.slideWidth * Math.floor(n.options.slidesToShow / 2) : 0;
                return !0 === n.options.swipeToSlide
                    ? (n.$slideTrack.find(".slick-slide").each(function (e, t) {
                        if (t.offsetLeft - s + d(t).outerWidth() / 2 > -1 * n.swipeLeft) return (i = t), !1;
                    }),
                    Math.abs(d(i).attr("data-slick-index") - n.currentSlide) || 1)
                    : n.options.slidesToScroll;
            }),
            (a.prototype.goTo = a.prototype.slickGoTo = function (e, t) {
                this.changeSlide({ data: { message: "index", index: parseInt(e) } }, t);
            }),
            (a.prototype.init = function (e) {
                var t = this;
                d(t.$slider).hasClass("slick-initialized") ||
                (d(t.$slider).addClass("slick-initialized"), t.buildRows(), t.buildOut(), t.setProps(), t.startLoad(), t.loadSlider(), t.initializeEvents(), t.updateArrows(), t.updateDots(), t.checkResponsive(!0), t.focusHandler()),
                e && t.$slider.trigger("init", [t]),
                !0 === t.options.accessibility && t.initADA(),
                t.options.autoplay && ((t.paused = !1), t.autoPlay());
            }),
            (a.prototype.initADA = function () {
                var i = this,
                    n = Math.ceil(i.slideCount / i.options.slidesToShow),
                    s = i.getNavigableIndexes().filter(function (e) {
                        return 0 <= e && e < i.slideCount;
                    });
                i.$slides.add(i.$slideTrack.find(".slick-cloned")).attr({ "aria-hidden": "true", tabindex: "-1" }).find("a, input, button, select").attr({ tabindex: "-1" }),
                null !== i.$dots &&
                (i.$slides.not(i.$slideTrack.find(".slick-cloned")).each(function (e) {
                    var t = s.indexOf(e);
                    d(this).attr({ role: "tabpanel", id: "slick-slide" + i.instanceUid + e, tabindex: -1 }), -1 !== t && d(this).attr({ "aria-describedby": "slick-slide-control" + i.instanceUid + t });
                }),
                    i.$dots
                        .attr("role", "tablist")
                        .find("li")
                        .each(function (e) {
                            var t = s[e];
                            d(this).attr({ role: "presentation" }),
                                d(this)
                                    .find("button")
                                    .first()
                                    .attr({ role: "tab", id: "slick-slide-control" + i.instanceUid + e, "aria-controls": "slick-slide" + i.instanceUid + t, "aria-label": e + 1 + " of " + n, "aria-selected": null, tabindex: "-1" });
                        })
                        .eq(i.currentSlide)
                        .find("button")
                        .attr({ "aria-selected": "true", tabindex: "0" })
                        .end());
                for (var e = i.currentSlide, t = e + i.options.slidesToShow; e < t; e++) i.$slides.eq(e).attr("tabindex", 0);
                i.activateADA();
            }),
            (a.prototype.initArrowEvents = function () {
                var e = this;
                !0 === e.options.arrows &&
                e.slideCount > e.options.slidesToShow &&
                (e.$prevArrow.off("click.slick").on("click.slick", { message: "previous" }, e.changeSlide),
                    e.$nextArrow.off("click.slick").on("click.slick", { message: "next" }, e.changeSlide),
                !0 === e.options.accessibility && (e.$prevArrow.on("keydown.slick", e.keyHandler), e.$nextArrow.on("keydown.slick", e.keyHandler)));
            }),
            (a.prototype.initDotEvents = function () {
                var e = this;
                !0 === e.options.dots && (d("li", e.$dots).on("click.slick", { message: "index" }, e.changeSlide), !0 === e.options.accessibility && e.$dots.on("keydown.slick", e.keyHandler)),
                !0 === e.options.dots && !0 === e.options.pauseOnDotsHover && d("li", e.$dots).on("mouseenter.slick", d.proxy(e.interrupt, e, !0)).on("mouseleave.slick", d.proxy(e.interrupt, e, !1));
            }),
            (a.prototype.initSlideEvents = function () {
                this.options.pauseOnHover && (this.$list.on("mouseenter.slick", d.proxy(this.interrupt, this, !0)), this.$list.on("mouseleave.slick", d.proxy(this.interrupt, this, !1)));
            }),
            (a.prototype.initializeEvents = function () {
                var e = this;
                e.initArrowEvents(),
                    e.initDotEvents(),
                    e.initSlideEvents(),
                    e.$list.on("touchstart.slick mousedown.slick", { action: "start" }, e.swipeHandler),
                    e.$list.on("touchmove.slick mousemove.slick", { action: "move" }, e.swipeHandler),
                    e.$list.on("touchend.slick mouseup.slick", { action: "end" }, e.swipeHandler),
                    e.$list.on("touchcancel.slick mouseleave.slick", { action: "end" }, e.swipeHandler),
                    e.$list.on("click.slick", e.clickHandler),
                    d(document).on(e.visibilityChange, d.proxy(e.visibility, e)),
                !0 === e.options.accessibility && e.$list.on("keydown.slick", e.keyHandler),
                !0 === e.options.focusOnSelect && d(e.$slideTrack).children().on("click.slick", e.selectHandler),
                    d(window).on("orientationchange.slick.slick-" + e.instanceUid, d.proxy(e.orientationChange, e)),
                    d(window).on("resize.slick.slick-" + e.instanceUid, d.proxy(e.resize, e)),
                    d("[draggable!=true]", e.$slideTrack).on("dragstart", e.preventDefault),
                    d(window).on("load.slick.slick-" + e.instanceUid, e.setPosition),
                    d(e.setPosition);
            }),
            (a.prototype.initUI = function () {
                !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && (this.$prevArrow.show(), this.$nextArrow.show()), !0 === this.options.dots && this.slideCount > this.options.slidesToShow && this.$dots.show();
            }),
            (a.prototype.keyHandler = function (e) {
                e.target.tagName.match("TEXTAREA|INPUT|SELECT") ||
                (37 === e.keyCode && !0 === this.options.accessibility
                    ? this.changeSlide({ data: { message: !0 === this.options.rtl ? "next" : "previous" } })
                    : 39 === e.keyCode && !0 === this.options.accessibility && this.changeSlide({ data: { message: !0 === this.options.rtl ? "previous" : "next" } }));
            }),
            (a.prototype.lazyLoad = function () {
                var e,
                    t,
                    i,
                    a = this;
                function n(e) {
                    d("img[data-lazy]", e).each(function () {
                        var e = d(this),
                            t = d(this).attr("data-lazy"),
                            i = d(this).attr("data-srcset"),
                            n = d(this).attr("data-sizes") || a.$slider.attr("data-sizes"),
                            s = document.createElement("img");
                        (s.onload = function () {
                            e.animate({ opacity: 0 }, 100, function () {
                                i && (e.attr("srcset", i), n && e.attr("sizes", n)),
                                    e.attr("src", t).animate({ opacity: 1 }, 200, function () {
                                        e.removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading");
                                    }),
                                    a.$slider.trigger("lazyLoaded", [a, e, t]);
                            });
                        }),
                            (s.onerror = function () {
                                e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), a.$slider.trigger("lazyLoadError", [a, e, t]);
                            }),
                            (s.src = t);
                    });
                }
                if (
                    (!0 === a.options.centerMode
                        ? (i =
                            !0 === a.options.infinite
                                ? (t = a.currentSlide + (a.options.slidesToShow / 2 + 1)) + a.options.slidesToShow + 2
                                : ((t = Math.max(0, a.currentSlide - (a.options.slidesToShow / 2 + 1))), a.options.slidesToShow / 2 + 1 + 2 + a.currentSlide))
                        : ((t = a.options.infinite ? a.options.slidesToShow + a.currentSlide : a.currentSlide), (i = Math.ceil(t + a.options.slidesToShow)), !0 === a.options.fade && (0 < t && t--, i <= a.slideCount && i++)),
                        (e = a.$slider.find(".slick-slide").slice(t, i)),
                    "anticipated" === a.options.lazyLoad)
                )
                    for (var s = t - 1, o = i, r = a.$slider.find(".slick-slide"), l = 0; l < a.options.slidesToScroll; l++) s < 0 && (s = a.slideCount - 1), (e = (e = e.add(r.eq(s))).add(r.eq(o))), s--, o++;
                n(e),
                    a.slideCount <= a.options.slidesToShow
                        ? n(a.$slider.find(".slick-slide"))
                        : a.currentSlide >= a.slideCount - a.options.slidesToShow
                            ? n(a.$slider.find(".slick-cloned").slice(0, a.options.slidesToShow))
                            : 0 === a.currentSlide && n(a.$slider.find(".slick-cloned").slice(-1 * a.options.slidesToShow));
            }),
            (a.prototype.loadSlider = function () {
                this.setPosition(), this.$slideTrack.css({ opacity: 1 }), this.$slider.removeClass("slick-loading"), this.initUI(), "progressive" === this.options.lazyLoad && this.progressiveLazyLoad();
            }),
            (a.prototype.next = a.prototype.slickNext = function () {
                this.changeSlide({ data: { message: "next" } });
            }),
            (a.prototype.orientationChange = function () {
                this.checkResponsive(), this.setPosition();
            }),
            (a.prototype.pause = a.prototype.slickPause = function () {
                this.autoPlayClear(), (this.paused = !0);
            }),
            (a.prototype.play = a.prototype.slickPlay = function () {
                this.autoPlay(), (this.options.autoplay = !0), (this.paused = !1), (this.focussed = !1), (this.interrupted = !1);
            }),
            (a.prototype.postSlide = function (e) {
                var t = this;
                t.unslicked ||
                (t.$slider.trigger("afterChange", [t, e]),
                    (t.animating = !1),
                t.slideCount > t.options.slidesToShow && t.setPosition(),
                    (t.swipeLeft = null),
                t.options.autoplay && t.autoPlay(),
                !0 === t.options.accessibility && (t.initADA(), t.options.focusOnChange && d(t.$slides.get(t.currentSlide)).attr("tabindex", 0).focus()));
            }),
            (a.prototype.prev = a.prototype.slickPrev = function () {
                this.changeSlide({ data: { message: "previous" } });
            }),
            (a.prototype.preventDefault = function (e) {
                e.preventDefault();
            }),
            (a.prototype.progressiveLazyLoad = function (e) {
                e = e || 1;
                var t,
                    i,
                    n,
                    s,
                    a = this,
                    o = d("img[data-lazy]", a.$slider);
                o.length
                    ? ((t = o.first()),
                        (i = t.attr("data-lazy")),
                        (n = t.attr("data-srcset")),
                        (s = t.attr("data-sizes") || a.$slider.attr("data-sizes")),
                        ((o = document.createElement("img")).onload = function () {
                            n && (t.attr("srcset", n), s && t.attr("sizes", s)),
                                t.attr("src", i).removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading"),
                            !0 === a.options.adaptiveHeight && a.setPosition(),
                                a.$slider.trigger("lazyLoaded", [a, t, i]),
                                a.progressiveLazyLoad();
                        }),
                        (o.onerror = function () {
                            e < 3
                                ? setTimeout(function () {
                                    a.progressiveLazyLoad(e + 1);
                                }, 500)
                                : (t.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), a.$slider.trigger("lazyLoadError", [a, t, i]), a.progressiveLazyLoad());
                        }),
                        (o.src = i))
                    : a.$slider.trigger("allImagesLoaded", [a]);
            }),
            (a.prototype.refresh = function (e) {
                var t = this,
                    i = t.slideCount - t.options.slidesToShow;
                !t.options.infinite && t.currentSlide > i && (t.currentSlide = i),
                t.slideCount <= t.options.slidesToShow && (t.currentSlide = 0),
                    (i = t.currentSlide),
                    t.destroy(!0),
                    d.extend(t, t.initials, { currentSlide: i }),
                    t.init(),
                e || t.changeSlide({ data: { message: "index", index: i } }, !1);
            }),
            (a.prototype.registerBreakpoints = function () {
                var e,
                    t,
                    i,
                    n = this,
                    s = n.options.responsive || null;
                if ("array" === d.type(s) && s.length) {
                    for (e in ((n.respondTo = n.options.respondTo || "window"), s))
                        if (((i = n.breakpoints.length - 1), s.hasOwnProperty(e))) {
                            for (t = s[e].breakpoint; 0 <= i; ) n.breakpoints[i] && n.breakpoints[i] === t && n.breakpoints.splice(i, 1), i--;
                            n.breakpoints.push(t), (n.breakpointSettings[t] = s[e].settings);
                        }
                    n.breakpoints.sort(function (e, t) {
                        return n.options.mobileFirst ? e - t : t - e;
                    });
                }
            }),
            (a.prototype.reinit = function () {
                var e = this;
                (e.$slides = e.$slideTrack.children(e.options.slide).addClass("slick-slide")),
                    (e.slideCount = e.$slides.length),
                e.currentSlide >= e.slideCount && 0 !== e.currentSlide && (e.currentSlide = e.currentSlide - e.options.slidesToScroll),
                e.slideCount <= e.options.slidesToShow && (e.currentSlide = 0),
                    e.registerBreakpoints(),
                    e.setProps(),
                    e.setupInfinite(),
                    e.buildArrows(),
                    e.updateArrows(),
                    e.initArrowEvents(),
                    e.buildDots(),
                    e.updateDots(),
                    e.initDotEvents(),
                    e.cleanUpSlideEvents(),
                    e.initSlideEvents(),
                    e.checkResponsive(!1, !0),
                !0 === e.options.focusOnSelect && d(e.$slideTrack).children().on("click.slick", e.selectHandler),
                    e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0),
                    e.setPosition(),
                    e.focusHandler(),
                    (e.paused = !e.options.autoplay),
                    e.autoPlay(),
                    e.$slider.trigger("reInit", [e]);
            }),
            (a.prototype.resize = function () {
                var e = this;
                d(window).width() !== e.windowWidth &&
                (clearTimeout(e.windowDelay),
                    (e.windowDelay = window.setTimeout(function () {
                        (e.windowWidth = d(window).width()), e.checkResponsive(), e.unslicked || e.setPosition();
                    }, 50)));
            }),
            (a.prototype.removeSlide = a.prototype.slickRemove = function (e, t, i) {
                var n = this;
                if (((e = "boolean" == typeof e ? (!0 === (t = e) ? 0 : n.slideCount - 1) : !0 === t ? --e : e), n.slideCount < 1 || e < 0 || e > n.slideCount - 1)) return !1;
                n.unload(),
                    (!0 === i ? n.$slideTrack.children() : n.$slideTrack.children(this.options.slide).eq(e)).remove(),
                    (n.$slides = n.$slideTrack.children(this.options.slide)),
                    n.$slideTrack.children(this.options.slide).detach(),
                    n.$slideTrack.append(n.$slides),
                    (n.$slidesCache = n.$slides),
                    n.reinit();
            }),
            (a.prototype.setCSS = function (e) {
                var t,
                    i,
                    n = this,
                    s = {};
                !0 === n.options.rtl && (e = -e),
                    (t = "left" == n.positionProp ? Math.ceil(e) + "px" : "0px"),
                    (i = "top" == n.positionProp ? Math.ceil(e) + "px" : "0px"),
                    (s[n.positionProp] = e),
                !1 === n.transformsEnabled || (!(s = {}) === n.cssTransitions ? (s[n.animType] = "translate(" + t + ", " + i + ")") : (s[n.animType] = "translate3d(" + t + ", " + i + ", 0px)")),
                    n.$slideTrack.css(s);
            }),
            (a.prototype.setDimensions = function () {
                var e = this;
                !1 === e.options.vertical
                    ? !0 === e.options.centerMode && e.$list.css({ padding: "0px " + e.options.centerPadding })
                    : (e.$list.height(e.$slides.first().outerHeight(!0) * e.options.slidesToShow), !0 === e.options.centerMode && e.$list.css({ padding: e.options.centerPadding + " 0px" })),
                    (e.listWidth = e.$list.width()),
                    (e.listHeight = e.$list.height()),
                    !1 === e.options.vertical && !1 === e.options.variableWidth
                        ? ((e.slideWidth = Math.ceil(e.listWidth / e.options.slidesToShow)), e.$slideTrack.width(Math.ceil(e.slideWidth * e.$slideTrack.children(".slick-slide").length)))
                        : !0 === e.options.variableWidth
                            ? e.$slideTrack.width(5e3 * e.slideCount)
                            : ((e.slideWidth = Math.ceil(e.listWidth)), e.$slideTrack.height(Math.ceil(e.$slides.first().outerHeight(!0) * e.$slideTrack.children(".slick-slide").length)));
                var t = e.$slides.first().outerWidth(!0) - e.$slides.first().width();
                !1 === e.options.variableWidth && e.$slideTrack.children(".slick-slide").width(e.slideWidth - t);
            }),
            (a.prototype.setFade = function () {
                var i,
                    n = this;
                n.$slides.each(function (e, t) {
                    (i = n.slideWidth * e * -1),
                        !0 === n.options.rtl ? d(t).css({ position: "relative", right: i, top: 0, zIndex: n.options.zIndex - 2, opacity: 0 }) : d(t).css({ position: "relative", left: i, top: 0, zIndex: n.options.zIndex - 2, opacity: 0 });
                }),
                    n.$slides.eq(n.currentSlide).css({ zIndex: n.options.zIndex - 1, opacity: 1 });
            }),
            (a.prototype.setHeight = function () {
                var e;
                1 === this.options.slidesToShow && !0 === this.options.adaptiveHeight && !1 === this.options.vertical && ((e = this.$slides.eq(this.currentSlide).outerHeight(!0)), this.$list.css("height", e));
            }),
            (a.prototype.setOption = a.prototype.slickSetOption = function () {
                var e,
                    t,
                    i,
                    n,
                    s,
                    a = this,
                    o = !1;
                if (
                    ("object" === d.type(arguments[0])
                        ? ((i = arguments[0]), (o = arguments[1]), (s = "multiple"))
                        : "string" === d.type(arguments[0]) &&
                        ((i = arguments[0]), (n = arguments[1]), (o = arguments[2]), "responsive" === arguments[0] && "array" === d.type(arguments[1]) ? (s = "responsive") : void 0 !== arguments[1] && (s = "single")),
                    "single" === s)
                )
                    a.options[i] = n;
                else if ("multiple" === s)
                    d.each(i, function (e, t) {
                        a.options[e] = t;
                    });
                else if ("responsive" === s)
                    for (t in n)
                        if ("array" !== d.type(a.options.responsive)) a.options.responsive = [n[t]];
                        else {
                            for (e = a.options.responsive.length - 1; 0 <= e; ) a.options.responsive[e].breakpoint === n[t].breakpoint && a.options.responsive.splice(e, 1), e--;
                            a.options.responsive.push(n[t]);
                        }
                o && (a.unload(), a.reinit());
            }),
            (a.prototype.setPosition = function () {
                this.setDimensions(), this.setHeight(), !1 === this.options.fade ? this.setCSS(this.getLeft(this.currentSlide)) : this.setFade(), this.$slider.trigger("setPosition", [this]);
            }),
            (a.prototype.setProps = function () {
                var e = this,
                    t = document.body.style;
                (e.positionProp = !0 === e.options.vertical ? "top" : "left"),
                    "top" === e.positionProp ? e.$slider.addClass("slick-vertical") : e.$slider.removeClass("slick-vertical"),
                (void 0 === t.WebkitTransition && void 0 === t.MozTransition && void 0 === t.msTransition) || (!0 === e.options.useCSS && (e.cssTransitions = !0)),
                e.options.fade && ("number" == typeof e.options.zIndex ? e.options.zIndex < 3 && (e.options.zIndex = 3) : (e.options.zIndex = e.defaults.zIndex)),
                void 0 !== t.OTransform && ((e.animType = "OTransform"), (e.transformType = "-o-transform"), (e.transitionType = "OTransition"), void 0 === t.perspectiveProperty && void 0 === t.webkitPerspective && (e.animType = !1)),
                void 0 !== t.MozTransform &&
                ((e.animType = "MozTransform"), (e.transformType = "-moz-transform"), (e.transitionType = "MozTransition"), void 0 === t.perspectiveProperty && void 0 === t.MozPerspective && (e.animType = !1)),
                void 0 !== t.webkitTransform &&
                ((e.animType = "webkitTransform"), (e.transformType = "-webkit-transform"), (e.transitionType = "webkitTransition"), void 0 === t.perspectiveProperty && void 0 === t.webkitPerspective && (e.animType = !1)),
                void 0 !== t.msTransform && ((e.animType = "msTransform"), (e.transformType = "-ms-transform"), (e.transitionType = "msTransition"), void 0 === t.msTransform && (e.animType = !1)),
                void 0 !== t.transform && !1 !== e.animType && ((e.animType = "transform"), (e.transformType = "transform"), (e.transitionType = "transition")),
                    (e.transformsEnabled = e.options.useTransform && null !== e.animType && !1 !== e.animType);
            }),
            (a.prototype.setSlideClasses = function (e) {
                var t,
                    i,
                    n,
                    s = this,
                    a = s.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true");
                s.$slides.eq(e).addClass("slick-current"),
                    !0 === s.options.centerMode
                        ? ((i = s.options.slidesToShow % 2 == 0 ? 1 : 0),
                            (n = Math.floor(s.options.slidesToShow / 2)),
                        !0 === s.options.infinite &&
                        (n <= e && e <= s.slideCount - 1 - n
                            ? s.$slides
                                .slice(e - n + i, e + n + 1)
                                .addClass("slick-active")
                                .attr("aria-hidden", "false")
                            : ((t = s.options.slidesToShow + e),
                                a
                                    .slice(t - n + 1 + i, t + n + 2)
                                    .addClass("slick-active")
                                    .attr("aria-hidden", "false")),
                            0 === e ? a.eq(a.length - 1 - s.options.slidesToShow).addClass("slick-center") : e === s.slideCount - 1 && a.eq(s.options.slidesToShow).addClass("slick-center")),
                            s.$slides.eq(e).addClass("slick-center"))
                        : 0 <= e && e <= s.slideCount - s.options.slidesToShow
                            ? s.$slides
                                .slice(e, e + s.options.slidesToShow)
                                .addClass("slick-active")
                                .attr("aria-hidden", "false")
                            : a.length <= s.options.slidesToShow
                                ? a.addClass("slick-active").attr("aria-hidden", "false")
                                : ((n = s.slideCount % s.options.slidesToShow),
                                    (t = !0 === s.options.infinite ? s.options.slidesToShow + e : e),
                                    (s.options.slidesToShow == s.options.slidesToScroll && s.slideCount - e < s.options.slidesToShow ? a.slice(t - (s.options.slidesToShow - n), t + n) : a.slice(t, t + s.options.slidesToShow))
                                        .addClass("slick-active")
                                        .attr("aria-hidden", "false")),
                ("ondemand" !== s.options.lazyLoad && "anticipated" !== s.options.lazyLoad) || s.lazyLoad();
            }),
            (a.prototype.setupInfinite = function () {
                var e,
                    t,
                    i,
                    n = this;
                if ((!0 === n.options.fade && (n.options.centerMode = !1), !0 === n.options.infinite && !1 === n.options.fade && ((t = null), n.slideCount > n.options.slidesToShow))) {
                    for (i = !0 === n.options.centerMode ? n.options.slidesToShow + 1 : n.options.slidesToShow, e = n.slideCount; e > n.slideCount - i; --e)
                        (t = e - 1),
                            d(n.$slides[t])
                                .clone(!0)
                                .attr("id", "")
                                .attr("data-slick-index", t - n.slideCount)
                                .prependTo(n.$slideTrack)
                                .addClass("slick-cloned");
                    for (e = 0; e < i + n.slideCount; e += 1)
                        (t = e),
                            d(n.$slides[t])
                                .clone(!0)
                                .attr("id", "")
                                .attr("data-slick-index", t + n.slideCount)
                                .appendTo(n.$slideTrack)
                                .addClass("slick-cloned");
                    n.$slideTrack
                        .find(".slick-cloned")
                        .find("[id]")
                        .each(function () {
                            d(this).attr("id", "");
                        });
                }
            }),
            (a.prototype.interrupt = function (e) {
                e || this.autoPlay(), (this.interrupted = e);
            }),
            (a.prototype.selectHandler = function (e) {
                (e = d(e.target).is(".slick-slide") ? d(e.target) : d(e.target).parents(".slick-slide")), (e = (e = parseInt(e.attr("data-slick-index"))) || 0);
                this.slideCount <= this.options.slidesToShow ? this.slideHandler(e, !1, !0) : this.slideHandler(e);
            }),
            (a.prototype.slideHandler = function (e, t, i) {
                var n,
                    s,
                    a,
                    o,
                    r = this;
                if (((t = t || !1), !((!0 === r.animating && !0 === r.options.waitForAnimate) || (!0 === r.options.fade && r.currentSlide === e))))
                    if (
                        (!1 === t && r.asNavFor(e),
                            (n = e),
                            (a = r.getLeft(n)),
                            (t = r.getLeft(r.currentSlide)),
                            (r.currentLeft = null === r.swipeLeft ? t : r.swipeLeft),
                        !1 === r.options.infinite && !1 === r.options.centerMode && (e < 0 || e > r.getDotCount() * r.options.slidesToScroll))
                    )
                        !1 === r.options.fade &&
                        ((n = r.currentSlide),
                            !0 !== i
                                ? r.animateSlide(t, function () {
                                    r.postSlide(n);
                                })
                                : r.postSlide(n));
                    else if (!1 === r.options.infinite && !0 === r.options.centerMode && (e < 0 || e > r.slideCount - r.options.slidesToScroll))
                        !1 === r.options.fade &&
                        ((n = r.currentSlide),
                            !0 !== i
                                ? r.animateSlide(t, function () {
                                    r.postSlide(n);
                                })
                                : r.postSlide(n));
                    else {
                        if (
                            (r.options.autoplay && clearInterval(r.autoPlayTimer),
                                (s =
                                    n < 0
                                        ? r.slideCount % r.options.slidesToScroll != 0
                                            ? r.slideCount - (r.slideCount % r.options.slidesToScroll)
                                            : r.slideCount + n
                                        : n >= r.slideCount
                                            ? r.slideCount % r.options.slidesToScroll != 0
                                                ? 0
                                                : n - r.slideCount
                                            : n),
                                (r.animating = !0),
                                r.$slider.trigger("beforeChange", [r, r.currentSlide, s]),
                                (t = r.currentSlide),
                                (r.currentSlide = s),
                                r.setSlideClasses(r.currentSlide),
                            r.options.asNavFor && (o = (o = r.getNavTarget()).slick("getSlick")).slideCount <= o.options.slidesToShow && o.setSlideClasses(r.currentSlide),
                                r.updateDots(),
                                r.updateArrows(),
                            !0 === r.options.fade)
                        )
                            return (
                                !0 !== i
                                    ? (r.fadeSlideOut(t),
                                        r.fadeSlide(s, function () {
                                            r.postSlide(s);
                                        }))
                                    : r.postSlide(s),
                                    void r.animateHeight()
                            );
                        !0 !== i
                            ? r.animateSlide(a, function () {
                                r.postSlide(s);
                            })
                            : r.postSlide(s);
                    }
            }),
            (a.prototype.startLoad = function () {
                var e = this;
                !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow.hide(), e.$nextArrow.hide()),
                !0 === e.options.dots && e.slideCount > e.options.slidesToShow && e.$dots.hide(),
                    e.$slider.addClass("slick-loading");
            }),
            (a.prototype.swipeDirection = function () {
                var e = this.touchObject.startX - this.touchObject.curX,
                    t = this.touchObject.startY - this.touchObject.curY,
                    e = Math.atan2(t, e),
                    e = Math.round((180 * e) / Math.PI);
                return (
                    e < 0 && (e = 360 - Math.abs(e)),
                        (e <= 45 && 0 <= e) || (e <= 360 && 315 <= e)
                            ? !1 === this.options.rtl
                                ? "left"
                                : "right"
                            : 135 <= e && e <= 225
                                ? !1 === this.options.rtl
                                    ? "right"
                                    : "left"
                                : !0 === this.options.verticalSwiping
                                    ? 35 <= e && e <= 135
                                        ? "down"
                                        : "up"
                                    : "vertical"
                );
            }),
            (a.prototype.swipeEnd = function (e) {
                var t,
                    i,
                    n = this;
                if (((n.dragging = !1), (n.swiping = !1), n.scrolling)) return (n.scrolling = !1);
                if (((n.interrupted = !1), (n.shouldClick = !(10 < n.touchObject.swipeLength)), void 0 === n.touchObject.curX)) return !1;
                if ((!0 === n.touchObject.edgeHit && n.$slider.trigger("edge", [n, n.swipeDirection()]), n.touchObject.swipeLength >= n.touchObject.minSwipe)) {
                    switch ((i = n.swipeDirection())) {
                        case "left":
                        case "down":
                            (t = n.options.swipeToSlide ? n.checkNavigable(n.currentSlide + n.getSlideCount()) : n.currentSlide + n.getSlideCount()), (n.currentDirection = 0);
                            break;
                        case "right":
                        case "up":
                            (t = n.options.swipeToSlide ? n.checkNavigable(n.currentSlide - n.getSlideCount()) : n.currentSlide - n.getSlideCount()), (n.currentDirection = 1);
                    }
                    "vertical" != i && (n.slideHandler(t), (n.touchObject = {}), n.$slider.trigger("swipe", [n, i]));
                } else n.touchObject.startX !== n.touchObject.curX && (n.slideHandler(n.currentSlide), (n.touchObject = {}));
            }),
            (a.prototype.swipeHandler = function (e) {
                var t = this;
                if (!(!1 === t.options.swipe || ("ontouchend" in document && !1 === t.options.swipe) || (!1 === t.options.draggable && -1 !== e.type.indexOf("mouse"))))
                    switch (
                        ((t.touchObject.fingerCount = e.originalEvent && void 0 !== e.originalEvent.touches ? e.originalEvent.touches.length : 1),
                            (t.touchObject.minSwipe = t.listWidth / t.options.touchThreshold),
                        !0 === t.options.verticalSwiping && (t.touchObject.minSwipe = t.listHeight / t.options.touchThreshold),
                            e.data.action)
                        ) {
                        case "start":
                            t.swipeStart(e);
                            break;
                        case "move":
                            t.swipeMove(e);
                            break;
                        case "end":
                            t.swipeEnd(e);
                    }
            }),
            (a.prototype.swipeMove = function (e) {
                var t,
                    i,
                    n = this,
                    s = void 0 !== e.originalEvent ? e.originalEvent.touches : null;
                return (
                    !(!n.dragging || n.scrolling || (s && 1 !== s.length)) &&
                    ((t = n.getLeft(n.currentSlide)),
                        (n.touchObject.curX = void 0 !== s ? s[0].pageX : e.clientX),
                        (n.touchObject.curY = void 0 !== s ? s[0].pageY : e.clientY),
                        (n.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(n.touchObject.curX - n.touchObject.startX, 2)))),
                        (i = Math.round(Math.sqrt(Math.pow(n.touchObject.curY - n.touchObject.startY, 2)))),
                        !n.options.verticalSwiping && !n.swiping && 4 < i
                            ? !(n.scrolling = !0)
                            : (!0 === n.options.verticalSwiping && (n.touchObject.swipeLength = i),
                                (s = n.swipeDirection()),
                            void 0 !== e.originalEvent && 4 < n.touchObject.swipeLength && ((n.swiping = !0), e.preventDefault()),
                                (i = (!1 === n.options.rtl ? 1 : -1) * (n.touchObject.curX > n.touchObject.startX ? 1 : -1)),
                            !0 === n.options.verticalSwiping && (i = n.touchObject.curY > n.touchObject.startY ? 1 : -1),
                                (e = n.touchObject.swipeLength),
                            (n.touchObject.edgeHit = !1) === n.options.infinite &&
                            ((0 === n.currentSlide && "right" === s) || (n.currentSlide >= n.getDotCount() && "left" === s)) &&
                            ((e = n.touchObject.swipeLength * n.options.edgeFriction), (n.touchObject.edgeHit = !0)),
                                !1 === n.options.vertical ? (n.swipeLeft = t + e * i) : (n.swipeLeft = t + e * (n.$list.height() / n.listWidth) * i),
                            !0 === n.options.verticalSwiping && (n.swipeLeft = t + e * i),
                            !0 !== n.options.fade && !1 !== n.options.touchMove && (!0 === n.animating ? ((n.swipeLeft = null), !1) : void n.setCSS(n.swipeLeft))))
                );
            }),
            (a.prototype.swipeStart = function (e) {
                var t,
                    i = this;
                if (((i.interrupted = !0), 1 !== i.touchObject.fingerCount || i.slideCount <= i.options.slidesToShow)) return !(i.touchObject = {});
                void 0 !== e.originalEvent && void 0 !== e.originalEvent.touches && (t = e.originalEvent.touches[0]),
                    (i.touchObject.startX = i.touchObject.curX = void 0 !== t ? t.pageX : e.clientX),
                    (i.touchObject.startY = i.touchObject.curY = void 0 !== t ? t.pageY : e.clientY),
                    (i.dragging = !0);
            }),
            (a.prototype.unfilterSlides = a.prototype.slickUnfilter = function () {
                null !== this.$slidesCache && (this.unload(), this.$slideTrack.children(this.options.slide).detach(), this.$slidesCache.appendTo(this.$slideTrack), this.reinit());
            }),
            (a.prototype.unload = function () {
                var e = this;
                d(".slick-cloned", e.$slider).remove(),
                e.$dots && e.$dots.remove(),
                e.$prevArrow && e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.remove(),
                e.$nextArrow && e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.remove(),
                    e.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "");
            }),
            (a.prototype.unslick = function (e) {
                this.$slider.trigger("unslick", [this, e]), this.destroy();
            }),
            (a.prototype.updateArrows = function () {
                var e = this;
                Math.floor(e.options.slidesToShow / 2);
                !0 === e.options.arrows &&
                e.slideCount > e.options.slidesToShow &&
                !e.options.infinite &&
                (e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"),
                    e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"),
                    0 === e.currentSlide
                        ? (e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"))
                        : ((e.currentSlide >= e.slideCount - e.options.slidesToShow && !1 === e.options.centerMode) || (e.currentSlide >= e.slideCount - 1 && !0 === e.options.centerMode)) &&
                        (e.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")));
            }),
            (a.prototype.updateDots = function () {
                null !== this.$dots &&
                (this.$dots.find("li").removeClass("slick-active").end(),
                    this.$dots
                        .find("li")
                        .eq(Math.floor(this.currentSlide / this.options.slidesToScroll))
                        .addClass("slick-active"));
            }),
            (a.prototype.visibility = function () {
                this.options.autoplay && (document[this.hidden] ? (this.interrupted = !0) : (this.interrupted = !1));
            }),
            (d.fn.slick = function () {
                for (var e, t = arguments[0], i = Array.prototype.slice.call(arguments, 1), n = this.length, s = 0; s < n; s++)
                    if (("object" == typeof t || void 0 === t ? (this[s].slick = new a(this[s], t)) : (e = this[s].slick[t].apply(this[s].slick, i)), void 0 !== e)) return e;
                return this;
            });
    }),
[].map ||
(Array.prototype.map = function (e, t) {
    for (var i = this.length, n = new Array(i), s = 0; s < i; s++) s in this && (n[s] = e.call(t, this[s], s, this));
    return n;
}),
[].filter ||
(Array.prototype.filter = function (e) {
    if (null == this) throw new TypeError();
    var t = Object(this),
        i = t.length >>> 0;
    if ("function" != typeof e) throw new TypeError();
    for (var n, s = [], a = arguments[1], o = 0; o < i; o++) o in t && ((n = t[o]), e.call(a, n, o, t) && s.push(n));
    return s;
}),
[].indexOf ||
(Array.prototype.indexOf = function (e) {
    if (null == this) throw new TypeError();
    var t = Object(this),
        i = t.length >>> 0;
    if (0 == i) return -1;
    var n = 0;
    if ((1 < arguments.length && ((n = Number(arguments[1])) != n ? (n = 0) : 0 !== n && n != 1 / 0 && n != -1 / 0 && (n = (0 < n || -1) * Math.floor(Math.abs(n)))), i <= n)) return -1;
    for (var s = 0 <= n ? n : Math.max(i - Math.abs(n), 0); s < i; s++) if (s in t && t[s] === e) return s;
    return -1;
});
var nativeSplit = String.prototype.split,
    compliantExecNpcg = void 0 === /()??/.exec("")[1];
if (
    ((String.prototype.split = function (e, t) {
        var i = this;
        if ("[object RegExp]" !== Object.prototype.toString.call(e)) return nativeSplit.call(i, e, t);
        var n,
            s,
            a,
            o,
            r = [],
            l = (e.ignoreCase ? "i" : "") + (e.multiline ? "m" : "") + (e.extended ? "x" : "") + (e.sticky ? "y" : ""),
            d = 0;
        for (
            e = new RegExp(e.source, l + "g"), i += "", compliantExecNpcg || (n = new RegExp("^" + e.source + "$(?!\\s)", l)), t = void 0 === t ? -1 >>> 0 : t >>> 0;
            (s = e.exec(i)) &&
            !(
                (a = s.index + s[0].length) > d &&
                (r.push(i.slice(d, s.index)),
                !compliantExecNpcg &&
                1 < s.length &&
                s[0].replace(n, function () {
                    for (var e = 1; e < arguments.length - 2; e++) void 0 === arguments[e] && (s[e] = void 0);
                }),
                1 < s.length && s.index < i.length && Array.prototype.push.apply(r, s.slice(1)),
                    (o = s[0].length),
                    (d = a),
                r.length >= t)
            );

        )
            e.lastIndex === s.index && e.lastIndex++;
        return d === i.length ? (!o && e.test("")) || r.push("") : r.push(i.slice(d)), r.length > t ? r.slice(0, t) : r;
    }),
    "undefined" == typeof jQuery)
)
    throw new Error("Mobileselect's JavaScript requires jQuery");
!(function (a) {
    a.fn.mobileSelect = function (s) {
        var e = a(this);
        return e.length
            ? "string" == typeof (s = s || {})
                ? ("destroy" === s &&
                e.each(function (e, t) {
                    t = a(t).attr("data-msid");
                    a.mobileSelect.elements[t].destroy(), delete a.mobileSelect.elements[t];
                }),
                ("sync" !== s && "refresh" !== s) ||
                e.each(function (e, t) {
                    t = a(t).attr("data-msid");
                    a.mobileSelect.elements[t].refresh();
                }),
                "hide" === s &&
                e.each(function (e, t) {
                    t = a(t).attr("data-msid");
                    a.mobileSelect.elements[t].hide();
                }),
                    void (
                        "show" === s &&
                        e.each(function (e, t) {
                            t = a(t).attr("data-msid");
                            a.mobileSelect.elements[t].show();
                        })
                    ))
                : (a.mobileSelect.defaults && a.extend(a.fn.mobileSelect.defaults, a.mobileSelect.defaults),
                    (s = a.extend({}, a.fn.mobileSelect.defaults, s)),
                    void e.each(function (e, t) {
                        var i = a(t);
                        if ("SELECT" !== i[0].tagName) return console.warn("Sorry, cannot initialized a " + i[0].tagName + " element"), !0;
                        if (void 0 !== i.attr("data-msid")) return console.error("This element is already Initialized"), !0;
                        var n = Math.floor(999999 * Math.random());
                        i.attr("data-msid", n);
                        t = new o(t, s);
                        a.mobileSelect.elements[n] = t;
                    }))
            : "no elements to process";
    };
    var o = function (e, t) {
        (this.$e = a(e)), a.extend(this, t), this.init();
    };
    (o.prototype = {
        init: function () {
            this._setUserOptions(), this._extractOptions(), this._buildHTML(), this._bindEvents();
        },
        _buildHTML: function () {
            var e;
            void 0 === this.$e.attr("data-triggerOn")
                ? (void 0 !== this.$e.attr("data-style") && (this.style = this.$e.attr("data-style")),
                    (e = this.$e.attr("disabled") || ""),
                    this.$e.before('<button class="btn ' + this.style + ' btn-mobileSelect-gen" ' + e + '><span class="text"></span> <span class="caret"></span></button>'),
                    (this.$triggerElement = this.$e.prev()),
                    this.$e.hide())
                : (this.$triggerElement = a(this.$e.attr("data-triggerOn"))),
                (this.$c = a('<div class="mobileSelect-container"></div>').addClass(this.theme).appendTo("body")),
                this.$c.html(a.fn.mobileSelect.defaults.template),
                this.$c
                    .children("div")
                    .css({ "-webkit-transition": "all " + this.animationSpeed / 1e3 + "s", transition: "all " + this.animationSpeed / 1e3 + "s" })
                    .css(this.padding)
                    .addClass("anim-" + this.animation),
                this.$c
                    .find(".mobileSelect-title")
                    .html(this.title)
                    .end()
                    .find(".mobileSelect-savebtn")
                    .html(this.buttonSave)
                    .end()
                    .find(".mobileSelect-clearbtn")
                    .html(this.buttonClear)
                    .end()
                    .find(".mobileSelect-cancelbtn")
                    .html(this.buttonCancel)
                    .end(),
                (this.$listcontainer = this.$c.find(".list-container")),
                this.isMultiple ? this.$listcontainer.data("multiple", "true") : this.$c.find(".mobileSelect-clearbtn").remove(),
                this._appendOptionsList();
        },
        _appendOptionsList: function () {
            this.$listcontainer.html("");
            var n = this,
                s = "";
            a.each(this.options, function (e, t) {
                var i;
                t.group && t.group !== s && (t.groupDisabled && (i = "disabled"), n.$listcontainer.append('<span class="mobileSelect-group" ' + i + ">" + t.group + "</span>"), (s = t.group)),
                (t.groupDisabled || t.disabled) && (i = "disabled"),
                    n.$listcontainer.append('<a href="#" class="mobileSelect-control" ' + i + ' data-value="' + t.value + '">' + t.text + "</a>");
            }),
                this.sync(),
                this._updateBtnCount();
        },
        _updateBtnCount: function () {
            if (this.$triggerElement.is("button") && this.$triggerElement.hasClass("btn-mobileSelect-gen")) {
                var e = this.$triggerElement.find(".text"),
                    t = this.$e.val();
                if (null === t) return e.html("Nothing selected"), !1;
                !this.isMultiple || 1 === t.length ? e.html(t) : e.html(t.length + " items selected");
            }
        },
        _bindEvents: function () {
            var t = this;
            this.$triggerElement.on("click", function () {
                t.show();
            }),
                this.$c.find(".mobileSelect-savebtn").on("click", function (e) {
                    e.preventDefault(), t.syncR(), t.hide();
                }),
                this.$c.find(".mobileSelect-clearbtn").on("click", function (e) {
                    e.preventDefault(), t.$listcontainer.find(".selected").removeClass("selected"), t.syncR(), t.hide();
                }),
                this.$c.find(".mobileSelect-cancelbtn").on("click", function (e) {
                    e.preventDefault(), t.hide();
                }),
                this.$c.find(".mobileSelect-control").on("click", function (e) {
                    e.preventDefault();
                    e = a(this);
                    if ("disabled" == e.attr("disabled")) return !1;
                    t.isMultiple ? e.toggleClass("selected") : e.siblings().removeClass("selected").end().addClass("selected");
                });
        },
        _unbindEvents: function () {
            this.$triggerElement.unbind("click"), this.$c.find(".mobileSelect-clearbtn").unbind("click"), this.$c.find(".mobileSelect-cancelbtn").unbind("click"), this.$c.find(".mobileSelect-control").unbind("click");
        },
        sync: function () {
            var e,
                t = this.$e.val();
            for (e in (this.isMultiple || (t = [t]), this.$c.find("a").removeClass("selected"), t)) this.$c.find('a[data-value="' + t[e] + '"]').addClass("selected");
        },
        syncR: function () {
            var e = [];
            this.$c.find(".selected").each(function () {
                e.push(a(this).data("value"));
            }),
                this.$e.val(e);
        },
        hide: function () {
            this.$c.children("div").addClass("anim-" + this.animation);
            var e = this;
            this._updateBtnCount(),
                setTimeout(function () {
                    e.$c.hide(), a("body").removeClass("mobileSelect-noscroll"), e.onClose.apply(e.$e);
                }, this.animationSpeed);
        },
        show: function () {
            this.$c.show(), this.sync(), a("body").addClass("mobileSelect-noscroll");
            var e = this;
            setTimeout(function () {
                e.$c.children("div").removeClass(a.mobileSelect.animations.join(" "));
            }, 10),
                this.onOpen.apply(this.$e);
        },
        _setUserOptions: function () {
            (this.isMultiple = !!this.$e.attr("multiple")),
            void 0 !== this.$e.data("title") && (this.title = this.$e.data("title")),
            void 0 !== this.$e.data("animation") && (this.animation = this.$e.data("animation")),
            void 0 !== this.$e.data("animation-speed") && (this.animationSpeed = this.$e.data("animation-speed")),
            void 0 !== this.$e.data("padding") && (this.padding = this.$e.data("padding")),
            void 0 !== this.$e.data("btntext-save") && (this.buttonSave = this.$e.data("btntext-save")),
            void 0 !== this.$e.data("btntext-clear") && (this.buttonClear = this.$e.data("btntext-clear")),
            void 0 !== this.$e.data("btntext-cancel") && (this.buttonCancel = this.$e.data("btntext-cancel")),
            void 0 !== this.$e.data("theme") && (this.theme = this.$e.data("theme")),
            "none" === this.animation && (this.animationSpeed = 0);
        },
        _extractOptions: function () {
            var s = [];
            a.each(this.$e.find("option"), function (e, t) {
                var i,
                    n = a(t);
                n.text() &&
                ((t = n.parent().is("optgroup") ? ((i = n.parent().attr("label")), n.parent().prop("disabled")) : (i = !1)), s.push({ value: n.val(), text: a.trim(n.text()), disabled: n.prop("disabled"), group: i, groupDisabled: t }));
            }),
                (this.options = s);
        },
        destroy: function () {
            this.$e.removeAttr("data-msid"), this._unbindEvents(), this.$triggerElement.remove(), this.$c.remove(), this.$e.show(), console.log("done ");
        },
        refresh: function () {
            this._extractOptions(), this._appendOptionsList(), this._unbindEvents(), this._bindEvents();
        },
    }),
        (a.mobileSelect = { elements: {}, animations: ["anim-top", "anim-bottom", "anim-left", "anim-right", "anim-opacity", "anim-scale", "anim-zoom", "anim-none"] }),
        (a.fn.mobileSelect.defaults = {
            template:
                '<div><div class="mobileSelect-title"></div><div class="list-container"></div><div class="mobileSelect-buttons"><a href="#" class="mobileSelect-savebtn"></a><a href="#" class="mobileSelect-clearbtn"></a><a href="#" class="mobileSelect-cancelbtn"></a></div></div>',
            title: "Select an option",
            buttonSave: "Save",
            buttonClear: "Clear",
            buttonCancel: "Cancel",
            padding: { top: "20px", left: "20px", right: "20px", bottom: "20px" },
            animation: "scale",
            animationSpeed: 400,
            theme: "white",
            onOpen: function () {},
            onClose: function () {},
            style: "btn-default",
        });
})(jQuery),
    (function (e, t) {
        "object" == typeof exports && "undefined" != typeof module ? (module.exports = t()) : "function" == typeof define && define.amd ? define(t) : (e.moment = t());
    })(this, function () {
        "use strict";
        var e, n;
        function f() {
            return e.apply(null, arguments);
        }
        function o(e) {
            return e instanceof Array || "[object Array]" === Object.prototype.toString.call(e);
        }
        function r(e) {
            return null != e && "[object Object]" === Object.prototype.toString.call(e);
        }
        function a(e) {
            return void 0 === e;
        }
        function l(e) {
            return "number" == typeof e || "[object Number]" === Object.prototype.toString.call(e);
        }
        function s(e) {
            return e instanceof Date || "[object Date]" === Object.prototype.toString.call(e);
        }
        function d(e, t) {
            for (var i = [], n = 0; n < e.length; ++n) i.push(t(e[n], n));
            return i;
        }
        function u(e, t) {
            return Object.prototype.hasOwnProperty.call(e, t);
        }
        function c(e, t) {
            for (var i in t) u(t, i) && (e[i] = t[i]);
            return u(t, "toString") && (e.toString = t.toString), u(t, "valueOf") && (e.valueOf = t.valueOf), e;
        }
        function h(e, t, i, n) {
            return Tt(e, t, i, n, !0).utc();
        }
        function m(e) {
            return (
                null == e._pf &&
                (e._pf = {
                    empty: !1,
                    unusedTokens: [],
                    unusedInput: [],
                    overflow: -2,
                    charsLeftOver: 0,
                    nullInput: !1,
                    invalidMonth: null,
                    invalidFormat: !1,
                    userInvalidated: !1,
                    iso: !1,
                    parsedDateParts: [],
                    meridiem: null,
                    rfc2822: !1,
                    weekdayMismatch: !1,
                }),
                    e._pf
            );
        }
        function p(e) {
            if (null == e._isValid) {
                var t = m(e),
                    i = n.call(t.parsedDateParts, function (e) {
                        return null != e;
                    }),
                    i = !isNaN(e._d.getTime()) && t.overflow < 0 && !t.empty && !t.invalidMonth && !t.invalidWeekday && !t.weekdayMismatch && !t.nullInput && !t.invalidFormat && !t.userInvalidated && (!t.meridiem || (t.meridiem && i));
                if ((e._strict && (i = i && 0 === t.charsLeftOver && 0 === t.unusedTokens.length && void 0 === t.bigHour), null != Object.isFrozen && Object.isFrozen(e))) return i;
                e._isValid = i;
            }
            return e._isValid;
        }
        function v(e) {
            var t = h(NaN);
            return null != e ? c(m(t), e) : (m(t).userInvalidated = !0), t;
        }
        n =
            Array.prototype.some ||
            function (e) {
                for (var t = Object(this), i = t.length >>> 0, n = 0; n < i; n++) if (n in t && e.call(this, t[n], n, t)) return !0;
                return !1;
            };
        var g = (f.momentProperties = []);
        function w(e, t) {
            var i, n, s;
            if (
                (a(t._isAMomentObject) || (e._isAMomentObject = t._isAMomentObject),
                a(t._i) || (e._i = t._i),
                a(t._f) || (e._f = t._f),
                a(t._l) || (e._l = t._l),
                a(t._strict) || (e._strict = t._strict),
                a(t._tzm) || (e._tzm = t._tzm),
                a(t._isUTC) || (e._isUTC = t._isUTC),
                a(t._offset) || (e._offset = t._offset),
                a(t._pf) || (e._pf = m(t)),
                a(t._locale) || (e._locale = t._locale),
                0 < g.length)
            )
                for (i = 0; i < g.length; i++) a((s = t[(n = g[i])])) || (e[n] = s);
            return e;
        }
        var t = !1;
        function y(e) {
            w(this, e), (this._d = new Date(null != e._d ? e._d.getTime() : NaN)), this.isValid() || (this._d = new Date(NaN)), !1 === t && ((t = !0), f.updateOffset(this), (t = !1));
        }
        function b(e) {
            return e instanceof y || (null != e && null != e._isAMomentObject);
        }
        function _(e) {
            return e < 0 ? Math.ceil(e) || 0 : Math.floor(e);
        }
        function k(e) {
            var t = +e,
                e = 0;
            return 0 != t && isFinite(t) && (e = _(t)), e;
        }
        function x(e, t, i) {
            for (var n = Math.min(e.length, t.length), s = Math.abs(e.length - t.length), a = 0, o = 0; o < n; o++) ((i && e[o] !== t[o]) || (!i && k(e[o]) !== k(t[o]))) && a++;
            return a + s;
        }
        function C(e) {
            !1 === f.suppressDeprecationWarnings && "undefined" != typeof console && console.warn && console.warn("Deprecation warning: " + e);
        }
        function i(s, a) {
            var o = !0;
            return c(function () {
                if ((null != f.deprecationHandler && f.deprecationHandler(null, s), o)) {
                    for (var e, t = [], i = 0; i < arguments.length; i++) {
                        if (((e = ""), "object" == typeof arguments[i])) {
                            for (var n in ((e += "\n[" + i + "] "), arguments[0])) e += n + ": " + arguments[0][n] + ", ";
                            e = e.slice(0, -2);
                        } else e = arguments[i];
                        t.push(e);
                    }
                    C(s + "\nArguments: " + Array.prototype.slice.call(t).join("") + "\n" + new Error().stack), (o = !1);
                }
                return a.apply(this, arguments);
            }, a);
        }
        var S,
            T = {};
        function $(e, t) {
            null != f.deprecationHandler && f.deprecationHandler(e, t), T[e] || (C(t), (T[e] = !0));
        }
        function E(e) {
            return e instanceof Function || "[object Function]" === Object.prototype.toString.call(e);
        }
        function D(e, t) {
            var i,
                n = c({}, e);
            for (i in t) u(t, i) && (r(e[i]) && r(t[i]) ? ((n[i] = {}), c(n[i], e[i]), c(n[i], t[i])) : null != t[i] ? (n[i] = t[i]) : delete n[i]);
            for (i in e) u(e, i) && !u(t, i) && r(e[i]) && (n[i] = c({}, n[i]));
            return n;
        }
        function M(e) {
            null != e && this.set(e);
        }
        (f.suppressDeprecationWarnings = !1),
            (f.deprecationHandler = null),
            (S =
                Object.keys ||
                function (e) {
                    var t,
                        i = [];
                    for (t in e) u(e, t) && i.push(t);
                    return i;
                });
        var O = {};
        function I(e, t) {
            var i = e.toLowerCase();
            O[i] = O[i + "s"] = O[t] = e;
        }
        function P(e) {
            return "string" == typeof e ? O[e] || O[e.toLowerCase()] : void 0;
        }
        function A(e) {
            var t,
                i,
                n = {};
            for (i in e) u(e, i) && (t = P(i)) && (n[t] = e[i]);
            return n;
        }
        var z = {};
        function L(e, t) {
            z[e] = t;
        }
        function W(e, t, i) {
            var n = "" + Math.abs(e),
                t = t - n.length;
            return (0 <= e ? (i ? "+" : "") : "-") + Math.pow(10, Math.max(0, t)).toString().substr(1) + n;
        }
        var N = /(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g,
            Y = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,
            j = {},
            H = {};
        function R(e, t, i, n) {
            var s =
                "string" == typeof n
                    ? function () {
                        return this[n]();
                    }
                    : n;
            e && (H[e] = s),
            t &&
            (H[t[0]] = function () {
                return W(s.apply(this, arguments), t[1], t[2]);
            }),
            i &&
            (H[i] = function () {
                return this.localeData().ordinal(s.apply(this, arguments), e);
            });
        }
        function F(e, t) {
            return e.isValid()
                ? ((t = B(t, e.localeData())),
                    (j[t] =
                        j[t] ||
                        (function (n) {
                            for (var e, s = n.match(N), t = 0, a = s.length; t < a; t++) H[s[t]] ? (s[t] = H[s[t]]) : (s[t] = (e = s[t]).match(/\[[\s\S]/) ? e.replace(/^\[|\]$/g, "") : e.replace(/\\/g, ""));
                            return function (e) {
                                for (var t = "", i = 0; i < a; i++) t += E(s[i]) ? s[i].call(e, n) : s[i];
                                return t;
                            };
                        })(t)),
                    j[t](e))
                : e.localeData().invalidDate();
        }
        function B(e, t) {
            var i = 5;
            function n(e) {
                return t.longDateFormat(e) || e;
            }
            for (Y.lastIndex = 0; 0 <= i && Y.test(e); ) (e = e.replace(Y, n)), (Y.lastIndex = 0), --i;
            return e;
        }
        var V = /\d/,
            U = /\d\d/,
            G = /\d{3}/,
            q = /\d{4}/,
            X = /[+-]?\d{6}/,
            Z = /\d\d?/,
            K = /\d\d\d\d?/,
            Q = /\d\d\d\d\d\d?/,
            J = /\d{1,3}/,
            ee = /\d{1,4}/,
            te = /[+-]?\d{1,6}/,
            ie = /\d+/,
            ne = /[+-]?\d+/,
            se = /Z|[+-]\d\d:?\d\d/gi,
            ae = /Z|[+-]\d\d(?::?\d\d)?/gi,
            oe = /[0-9]{0,256}['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFF07\uFF10-\uFFEF]{1,256}|[\u0600-\u06FF\/]{1,256}(\s*?[\u0600-\u06FF]{1,256}){1,2}/i,
            re = {};
        function le(e, i, n) {
            re[e] = E(i)
                ? i
                : function (e, t) {
                    return e && n ? n : i;
                };
        }
        function de(e, t) {
            return u(re, e)
                ? re[e](t._strict, t._locale)
                : new RegExp(
                    ce(
                        e.replace("\\", "").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function (e, t, i, n, s) {
                            return t || i || n || s;
                        })
                    )
                );
        }
        function ce(e) {
            return e.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&");
        }
        var ue = {};
        function he(e, i) {
            var t,
                n = i;
            for (
                "string" == typeof e && (e = [e]),
                l(i) &&
                (n = function (e, t) {
                    t[i] = k(e);
                }),
                    t = 0;
                t < e.length;
                t++
            )
                ue[e[t]] = n;
        }
        function pe(e, s) {
            he(e, function (e, t, i, n) {
                (i._w = i._w || {}), s(e, i._w, i, n);
            });
        }
        var fe = 0,
            me = 1,
            ve = 2,
            ge = 3,
            we = 4,
            ye = 5,
            be = 6,
            _e = 7,
            ke = 8;
        function xe(e) {
            return Ce(e) ? 366 : 365;
        }
        function Ce(e) {
            return (e % 4 == 0 && e % 100 != 0) || e % 400 == 0;
        }
        R("Y", 0, 0, function () {
            var e = this.year();
            return e <= 9999 ? "" + e : "+" + e;
        }),
            R(0, ["YY", 2], 0, function () {
                return this.year() % 100;
            }),
            R(0, ["YYYY", 4], 0, "year"),
            R(0, ["YYYYY", 5], 0, "year"),
            R(0, ["YYYYYY", 6, !0], 0, "year"),
            I("year", "y"),
            L("year", 1),
            le("Y", ne),
            le("YY", Z, U),
            le("YYYY", ee, q),
            le("YYYYY", te, X),
            le("YYYYYY", te, X),
            he(["YYYYY", "YYYYYY"], fe),
            he("YYYY", function (e, t) {
                t[fe] = 2 === e.length ? f.parseTwoDigitYear(e) : k(e);
            }),
            he("YY", function (e, t) {
                t[fe] = f.parseTwoDigitYear(e);
            }),
            he("Y", function (e, t) {
                t[fe] = parseInt(e, 10);
            }),
            (f.parseTwoDigitYear = function (e) {
                return k(e) + (68 < k(e) ? 1900 : 2e3);
            });
        var Se,
            Te = $e("FullYear", !0);
        function $e(t, i) {
            return function (e) {
                return null != e ? (De(this, t, e), f.updateOffset(this, i), this) : Ee(this, t);
            };
        }
        function Ee(e, t) {
            return e.isValid() ? e._d["get" + (e._isUTC ? "UTC" : "") + t]() : NaN;
        }
        function De(e, t, i) {
            e.isValid() && !isNaN(i) && ("FullYear" === t && Ce(e.year()) && 1 === e.month() && 29 === e.date() ? e._d["set" + (e._isUTC ? "UTC" : "") + t](i, e.month(), Me(i, e.month())) : e._d["set" + (e._isUTC ? "UTC" : "") + t](i));
        }
        function Me(e, t) {
            if (isNaN(e) || isNaN(t)) return NaN;
            var i,
                i = ((t % (i = 12)) + i) % i;
            return (e += (t - i) / 12), 1 == i ? (Ce(e) ? 29 : 28) : 31 - ((i % 7) % 2);
        }
        (Se =
            Array.prototype.indexOf ||
            function (e) {
                for (var t = 0; t < this.length; ++t) if (this[t] === e) return t;
                return -1;
            }),
            R("M", ["MM", 2], "Mo", function () {
                return this.month() + 1;
            }),
            R("MMM", 0, 0, function (e) {
                return this.localeData().monthsShort(this, e);
            }),
            R("MMMM", 0, 0, function (e) {
                return this.localeData().months(this, e);
            }),
            I("month", "M"),
            L("month", 8),
            le("M", Z),
            le("MM", Z, U),
            le("MMM", function (e, t) {
                return t.monthsShortRegex(e);
            }),
            le("MMMM", function (e, t) {
                return t.monthsRegex(e);
            }),
            he(["M", "MM"], function (e, t) {
                t[me] = k(e) - 1;
            }),
            he(["MMM", "MMMM"], function (e, t, i, n) {
                n = i._locale.monthsParse(e, n, i._strict);
                null != n ? (t[me] = n) : (m(i).invalidMonth = e);
            });
        var Oe = /D[oD]?(\[[^\[\]]*\]|\s)+MMMM?/,
            Ie = "January_February_March_April_May_June_July_August_September_October_November_December".split("_");
        var Pe = "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_");
        function Ae(e, t) {
            var i;
            if (!e.isValid()) return e;
            if ("string" == typeof t)
                if (/^\d+$/.test(t)) t = k(t);
                else if (!l((t = e.localeData().monthsParse(t)))) return e;
            return (i = Math.min(e.date(), Me(e.year(), t))), e._d["set" + (e._isUTC ? "UTC" : "") + "Month"](t, i), e;
        }
        function ze(e) {
            return null != e ? (Ae(this, e), f.updateOffset(this, !0), this) : Ee(this, "Month");
        }
        var Le = oe;
        var We = oe;
        function Ne() {
            function e(e, t) {
                return t.length - e.length;
            }
            for (var t, i = [], n = [], s = [], a = 0; a < 12; a++) (t = h([2e3, a])), i.push(this.monthsShort(t, "")), n.push(this.months(t, "")), s.push(this.months(t, "")), s.push(this.monthsShort(t, ""));
            for (i.sort(e), n.sort(e), s.sort(e), a = 0; a < 12; a++) (i[a] = ce(i[a])), (n[a] = ce(n[a]));
            for (a = 0; a < 24; a++) s[a] = ce(s[a]);
            (this._monthsRegex = new RegExp("^(" + s.join("|") + ")", "i")),
                (this._monthsShortRegex = this._monthsRegex),
                (this._monthsStrictRegex = new RegExp("^(" + n.join("|") + ")", "i")),
                (this._monthsShortStrictRegex = new RegExp("^(" + i.join("|") + ")", "i"));
        }
        function Ye(e) {
            var t = new Date(Date.UTC.apply(null, arguments));
            return e < 100 && 0 <= e && isFinite(t.getUTCFullYear()) && t.setUTCFullYear(e), t;
        }
        function je(e, t, i) {
            i = 7 + t - i;
            return i - ((7 + Ye(e, 0, i).getUTCDay() - t) % 7) - 1;
        }
        function He(e, t, i, n, s) {
            var a,
                s = 1 + 7 * (t - 1) + ((7 + i - n) % 7) + je(e, n, s),
                s = s <= 0 ? xe((a = e - 1)) + s : s > xe(e) ? ((a = e + 1), s - xe(e)) : ((a = e), s);
            return { year: a, dayOfYear: s };
        }
        function Re(e, t, i) {
            var n,
                s,
                a = je(e.year(), t, i),
                a = Math.floor((e.dayOfYear() - a - 1) / 7) + 1;
            return a < 1 ? (n = a + Fe((s = e.year() - 1), t, i)) : a > Fe(e.year(), t, i) ? ((n = a - Fe(e.year(), t, i)), (s = e.year() + 1)) : ((s = e.year()), (n = a)), { week: n, year: s };
        }
        function Fe(e, t, i) {
            var n = je(e, t, i),
                i = je(e + 1, t, i);
            return (xe(e) - n + i) / 7;
        }
        R("w", ["ww", 2], "wo", "week"),
            R("W", ["WW", 2], "Wo", "isoWeek"),
            I("week", "w"),
            I("isoWeek", "W"),
            L("week", 5),
            L("isoWeek", 5),
            le("w", Z),
            le("ww", Z, U),
            le("W", Z),
            le("WW", Z, U),
            pe(["w", "ww", "W", "WW"], function (e, t, i, n) {
                t[n.substr(0, 1)] = k(e);
            });
        R("d", 0, "do", "day"),
            R("dd", 0, 0, function (e) {
                return this.localeData().weekdaysMin(this, e);
            }),
            R("ddd", 0, 0, function (e) {
                return this.localeData().weekdaysShort(this, e);
            }),
            R("dddd", 0, 0, function (e) {
                return this.localeData().weekdays(this, e);
            }),
            R("e", 0, 0, "weekday"),
            R("E", 0, 0, "isoWeekday"),
            I("day", "d"),
            I("weekday", "e"),
            I("isoWeekday", "E"),
            L("day", 11),
            L("weekday", 11),
            L("isoWeekday", 11),
            le("d", Z),
            le("e", Z),
            le("E", Z),
            le("dd", function (e, t) {
                return t.weekdaysMinRegex(e);
            }),
            le("ddd", function (e, t) {
                return t.weekdaysShortRegex(e);
            }),
            le("dddd", function (e, t) {
                return t.weekdaysRegex(e);
            }),
            pe(["dd", "ddd", "dddd"], function (e, t, i, n) {
                n = i._locale.weekdaysParse(e, n, i._strict);
                null != n ? (t.d = n) : (m(i).invalidWeekday = e);
            }),
            pe(["d", "e", "E"], function (e, t, i, n) {
                t[n] = k(e);
            });
        var Be = "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_");
        var Ve = "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_");
        var Ue = "Su_Mo_Tu_We_Th_Fr_Sa".split("_");
        var Ge = oe;
        var qe = oe;
        var Xe = oe;
        function Ze() {
            function e(e, t) {
                return t.length - e.length;
            }
            for (var t, i, n, s = [], a = [], o = [], r = [], l = 0; l < 7; l++)
                (n = h([2e3, 1]).day(l)), (t = this.weekdaysMin(n, "")), (i = this.weekdaysShort(n, "")), (n = this.weekdays(n, "")), s.push(t), a.push(i), o.push(n), r.push(t), r.push(i), r.push(n);
            for (s.sort(e), a.sort(e), o.sort(e), r.sort(e), l = 0; l < 7; l++) (a[l] = ce(a[l])), (o[l] = ce(o[l])), (r[l] = ce(r[l]));
            (this._weekdaysRegex = new RegExp("^(" + r.join("|") + ")", "i")),
                (this._weekdaysShortRegex = this._weekdaysRegex),
                (this._weekdaysMinRegex = this._weekdaysRegex),
                (this._weekdaysStrictRegex = new RegExp("^(" + o.join("|") + ")", "i")),
                (this._weekdaysShortStrictRegex = new RegExp("^(" + a.join("|") + ")", "i")),
                (this._weekdaysMinStrictRegex = new RegExp("^(" + s.join("|") + ")", "i"));
        }
        function Ke() {
            return this.hours() % 12 || 12;
        }
        function Qe(e, t) {
            R(e, 0, 0, function () {
                return this.localeData().meridiem(this.hours(), this.minutes(), t);
            });
        }
        function Je(e, t) {
            return t._meridiemParse;
        }
        R("H", ["HH", 2], 0, "hour"),
            R("h", ["hh", 2], 0, Ke),
            R("k", ["kk", 2], 0, function () {
                return this.hours() || 24;
            }),
            R("hmm", 0, 0, function () {
                return "" + Ke.apply(this) + W(this.minutes(), 2);
            }),
            R("hmmss", 0, 0, function () {
                return "" + Ke.apply(this) + W(this.minutes(), 2) + W(this.seconds(), 2);
            }),
            R("Hmm", 0, 0, function () {
                return "" + this.hours() + W(this.minutes(), 2);
            }),
            R("Hmmss", 0, 0, function () {
                return "" + this.hours() + W(this.minutes(), 2) + W(this.seconds(), 2);
            }),
            Qe("a", !0),
            Qe("A", !1),
            I("hour", "h"),
            L("hour", 13),
            le("a", Je),
            le("A", Je),
            le("H", Z),
            le("h", Z),
            le("k", Z),
            le("HH", Z, U),
            le("hh", Z, U),
            le("kk", Z, U),
            le("hmm", K),
            le("hmmss", Q),
            le("Hmm", K),
            le("Hmmss", Q),
            he(["H", "HH"], ge),
            he(["k", "kk"], function (e, t, i) {
                e = k(e);
                t[ge] = 24 === e ? 0 : e;
            }),
            he(["a", "A"], function (e, t, i) {
                (i._isPm = i._locale.isPM(e)), (i._meridiem = e);
            }),
            he(["h", "hh"], function (e, t, i) {
                (t[ge] = k(e)), (m(i).bigHour = !0);
            }),
            he("hmm", function (e, t, i) {
                var n = e.length - 2;
                (t[ge] = k(e.substr(0, n))), (t[we] = k(e.substr(n))), (m(i).bigHour = !0);
            }),
            he("hmmss", function (e, t, i) {
                var n = e.length - 4,
                    s = e.length - 2;
                (t[ge] = k(e.substr(0, n))), (t[we] = k(e.substr(n, 2))), (t[ye] = k(e.substr(s))), (m(i).bigHour = !0);
            }),
            he("Hmm", function (e, t, i) {
                var n = e.length - 2;
                (t[ge] = k(e.substr(0, n))), (t[we] = k(e.substr(n)));
            }),
            he("Hmmss", function (e, t, i) {
                var n = e.length - 4,
                    s = e.length - 2;
                (t[ge] = k(e.substr(0, n))), (t[we] = k(e.substr(n, 2))), (t[ye] = k(e.substr(s)));
            });
        var et,
            tt = $e("Hours", !0),
            it = {
                calendar: { sameDay: "[Today at] LT", nextDay: "[Tomorrow at] LT", nextWeek: "dddd [at] LT", lastDay: "[Yesterday at] LT", lastWeek: "[Last] dddd [at] LT", sameElse: "L" },
                longDateFormat: { LTS: "h:mm:ss A", LT: "h:mm A", L: "MM/DD/YYYY", LL: "MMMM D, YYYY", LLL: "MMMM D, YYYY h:mm A", LLLL: "dddd, MMMM D, YYYY h:mm A" },
                invalidDate: "Invalid date",
                ordinal: "%d",
                dayOfMonthOrdinalParse: /\d{1,2}/,
                relativeTime: {
                    future: "in %s",
                    past: "%s ago",
                    s: "a few seconds",
                    ss: "%d seconds",
                    m: "a minute",
                    mm: "%d minutes",
                    h: "an hour",
                    hh: "%d hours",
                    d: "a day",
                    dd: "%d days",
                    M: "a month",
                    MM: "%d months",
                    y: "a year",
                    yy: "%d years",
                },
                months: Ie,
                monthsShort: Pe,
                week: { dow: 0, doy: 6 },
                weekdays: Be,
                weekdaysMin: Ue,
                weekdaysShort: Ve,
                meridiemParse: /[ap]\.?m?\.?/i,
            },
            nt = {},
            st = {};
        function at(e) {
            return e && e.toLowerCase().replace("_", "-");
        }
        function ot(e) {
            if (!nt[e] && "undefined" != typeof module && module && module.exports)
                try {
                    var t = et._abbr;
                    require("./locale/" + e), rt(t);
                } catch (e) {}
            return nt[e];
        }
        function rt(e, t) {
            return e && ((t = a(t) ? dt(e) : lt(e, t)) ? (et = t) : "undefined" != typeof console && console.warn && console.warn("Locale " + e + " not found. Did you forget to load it?")), et._abbr;
        }
        function lt(e, t) {
            if (null === t) return delete nt[e], null;
            var i,
                n = it;
            if (((t.abbr = e), null != nt[e]))
                $(
                    "defineLocaleOverride",
                    "use moment.updateLocale(localeName, config) to change an existing locale. moment.defineLocale(localeName, config) should only be used for creating a new locale See http://momentjs.com/guides/#/warnings/define-locale/ for more info."
                ),
                    (n = nt[e]._config);
            else if (null != t.parentLocale)
                if (null != nt[t.parentLocale]) n = nt[t.parentLocale]._config;
                else {
                    if (null == (i = ot(t.parentLocale))) return st[t.parentLocale] || (st[t.parentLocale] = []), st[t.parentLocale].push({ name: e, config: t }), null;
                    n = i._config;
                }
            return (
                (nt[e] = new M(D(n, t))),
                st[e] &&
                st[e].forEach(function (e) {
                    lt(e.name, e.config);
                }),
                    rt(e),
                    nt[e]
            );
        }
        function dt(e) {
            var t;
            if ((e && e._locale && e._locale._abbr && (e = e._locale._abbr), !e)) return et;
            if (!o(e)) {
                if ((t = ot(e))) return t;
                e = [e];
            }
            return (function (e) {
                for (var t, i, n, s, a = 0; a < e.length; ) {
                    for (t = (s = at(e[a]).split("-")).length, i = (i = at(e[a + 1])) ? i.split("-") : null; 0 < t; ) {
                        if ((n = ot(s.slice(0, t).join("-")))) return n;
                        if (i && i.length >= t && x(s, i, !0) >= t - 1) break;
                        t--;
                    }
                    a++;
                }
                return et;
            })(e);
        }
        function ct(e) {
            var t = e._a;
            return (
                t &&
                -2 === m(e).overflow &&
                ((t =
                    t[me] < 0 || 11 < t[me]
                        ? me
                        : t[ve] < 1 || t[ve] > Me(t[fe], t[me])
                            ? ve
                            : t[ge] < 0 || 24 < t[ge] || (24 === t[ge] && (0 !== t[we] || 0 !== t[ye] || 0 !== t[be]))
                                ? ge
                                : t[we] < 0 || 59 < t[we]
                                    ? we
                                    : t[ye] < 0 || 59 < t[ye]
                                        ? ye
                                        : t[be] < 0 || 999 < t[be]
                                            ? be
                                            : -1),
                m(e)._overflowDayOfYear && (t < fe || ve < t) && (t = ve),
                m(e)._overflowWeeks && -1 === t && (t = _e),
                m(e)._overflowWeekday && -1 === t && (t = ke),
                    (m(e).overflow = t)),
                    e
            );
        }
        function ut(e, t, i) {
            return null != e ? e : null != t ? t : i;
        }
        function ht(e) {
            var t,
                i,
                n,
                s,
                a,
                o,
                r,
                l,
                d,
                c,
                u,
                h,
                p = [];
            if (!e._d) {
                for (
                    a = e,
                        h = new Date(f.now()),
                        i = a._useUTC ? [h.getUTCFullYear(), h.getUTCMonth(), h.getUTCDate()] : [h.getFullYear(), h.getMonth(), h.getDate()],
                    e._w &&
                    null == e._a[ve] &&
                    null == e._a[me] &&
                    (null != (a = (s = e)._w).GG || null != a.W || null != a.E
                        ? ((d = 1), (c = 4), (o = ut(a.GG, s._a[fe], Re($t(), 1, 4).year)), (r = ut(a.W, 1)), ((l = ut(a.E, 1)) < 1 || 7 < l) && (u = !0))
                        : ((d = s._locale._week.dow),
                            (c = s._locale._week.doy),
                            (h = Re($t(), d, c)),
                            (o = ut(a.gg, s._a[fe], h.year)),
                            (r = ut(a.w, h.week)),
                            null != a.d ? ((l = a.d) < 0 || 6 < l) && (u = !0) : null != a.e ? ((l = a.e + d), (a.e < 0 || 6 < a.e) && (u = !0)) : (l = d)),
                        r < 1 || r > Fe(o, d, c) ? (m(s)._overflowWeeks = !0) : null != u ? (m(s)._overflowWeekday = !0) : ((c = He(o, r, l, d, c)), (s._a[fe] = c.year), (s._dayOfYear = c.dayOfYear))),
                    null != e._dayOfYear &&
                    ((n = ut(e._a[fe], i[fe])), (e._dayOfYear > xe(n) || 0 === e._dayOfYear) && (m(e)._overflowDayOfYear = !0), (n = Ye(n, 0, e._dayOfYear)), (e._a[me] = n.getUTCMonth()), (e._a[ve] = n.getUTCDate())),
                        t = 0;
                    t < 3 && null == e._a[t];
                    ++t
                )
                    e._a[t] = p[t] = i[t];
                for (; t < 7; t++) e._a[t] = p[t] = null == e._a[t] ? (2 === t ? 1 : 0) : e._a[t];
                24 === e._a[ge] && 0 === e._a[we] && 0 === e._a[ye] && 0 === e._a[be] && ((e._nextDay = !0), (e._a[ge] = 0)),
                    (e._d = (e._useUTC
                            ? Ye
                            : function (e, t, i, n, s, a, o) {
                                return (o = new Date(e, t, i, n, s, a, o)), e < 100 && 0 <= e && isFinite(o.getFullYear()) && o.setFullYear(e), o;
                            }
                    ).apply(null, p)),
                    (n = e._useUTC ? e._d.getUTCDay() : e._d.getDay()),
                null != e._tzm && e._d.setUTCMinutes(e._d.getUTCMinutes() - e._tzm),
                e._nextDay && (e._a[ge] = 24),
                e._w && void 0 !== e._w.d && e._w.d !== n && (m(e).weekdayMismatch = !0);
            }
        }
        var pt = /^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,
            ft = /^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,
            mt = /Z|[+-]\d\d(?::?\d\d)?/,
            vt = [
                ["YYYYYY-MM-DD", /[+-]\d{6}-\d\d-\d\d/],
                ["YYYY-MM-DD", /\d{4}-\d\d-\d\d/],
                ["GGGG-[W]WW-E", /\d{4}-W\d\d-\d/],
                ["GGGG-[W]WW", /\d{4}-W\d\d/, !1],
                ["YYYY-DDD", /\d{4}-\d{3}/],
                ["YYYY-MM", /\d{4}-\d\d/, !1],
                ["YYYYYYMMDD", /[+-]\d{10}/],
                ["YYYYMMDD", /\d{8}/],
                ["GGGG[W]WWE", /\d{4}W\d{3}/],
                ["GGGG[W]WW", /\d{4}W\d{2}/, !1],
                ["YYYYDDD", /\d{7}/],
            ],
            gt = [
                ["HH:mm:ss.SSSS", /\d\d:\d\d:\d\d\.\d+/],
                ["HH:mm:ss,SSSS", /\d\d:\d\d:\d\d,\d+/],
                ["HH:mm:ss", /\d\d:\d\d:\d\d/],
                ["HH:mm", /\d\d:\d\d/],
                ["HHmmss.SSSS", /\d\d\d\d\d\d\.\d+/],
                ["HHmmss,SSSS", /\d\d\d\d\d\d,\d+/],
                ["HHmmss", /\d\d\d\d\d\d/],
                ["HHmm", /\d\d\d\d/],
                ["HH", /\d\d/],
            ],
            wt = /^\/?Date\((\-?\d+)/i;
        function yt(e) {
            var t,
                i,
                n,
                s,
                a,
                o,
                r = e._i,
                l = pt.exec(r) || ft.exec(r);
            if (l) {
                for (m(e).iso = !0, t = 0, i = vt.length; t < i; t++)
                    if (vt[t][1].exec(l[1])) {
                        (s = vt[t][0]), (n = !1 !== vt[t][2]);
                        break;
                    }
                if (null != s) {
                    if (l[3]) {
                        for (t = 0, i = gt.length; t < i; t++)
                            if (gt[t][1].exec(l[3])) {
                                a = (l[2] || " ") + gt[t][0];
                                break;
                            }
                        if (null == a) return void (e._isValid = !1);
                    }
                    if (n || null == a) {
                        if (l[4]) {
                            if (!mt.exec(l[4])) return void (e._isValid = !1);
                            o = "Z";
                        }
                        (e._f = s + (a || "") + (o || "")), Ct(e);
                    } else e._isValid = !1;
                } else e._isValid = !1;
            } else e._isValid = !1;
        }
        var bt = /^(?:(Mon|Tue|Wed|Thu|Fri|Sat|Sun),?\s)?(\d{1,2})\s(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s(\d{2,4})\s(\d\d):(\d\d)(?::(\d\d))?\s(?:(UT|GMT|[ECMP][SD]T)|([Zz])|([+-]\d{4}))$/;
        function _t(e, t, i, n, s, a) {
            s = [
                (function (e) {
                    e = parseInt(e, 10);
                    {
                        if (e <= 49) return 2e3 + e;
                        if (e <= 999) return 1900 + e;
                    }
                    return e;
                })(e),
                Pe.indexOf(t),
                parseInt(i, 10),
                parseInt(n, 10),
                parseInt(s, 10),
            ];
            return a && s.push(parseInt(a, 10)), s;
        }
        var kt = { UT: 0, GMT: 0, EDT: -240, EST: -300, CDT: -300, CST: -360, MDT: -360, MST: -420, PDT: -420, PST: -480 };
        function xt(e) {
            var t,
                i,
                n,
                s,
                a = bt.exec(
                    e._i
                        .replace(/\([^)]*\)|[\n\t]/g, " ")
                        .replace(/(\s\s+)/g, " ")
                        .replace(/^\s\s*/, "")
                        .replace(/\s\s*$/, "")
                );
            a
                ? ((t = _t(a[4], a[3], a[2], a[5], a[6], a[7])),
                    (i = a[1]),
                    (n = t),
                    (s = e),
                    i && Ve.indexOf(i) !== new Date(n[0], n[1], n[2]).getDay()
                        ? ((m(s).weekdayMismatch = !0), (s._isValid = !1))
                        : ((e._a = t),
                            (e._tzm = ((s = a[8]), (t = a[9]), (a = a[10]), s ? kt[s] : t ? 0 : 60 * (((t = parseInt(a, 10)) - (a = t % 100)) / 100) + a)),
                            (e._d = Ye.apply(null, e._a)),
                            e._d.setUTCMinutes(e._d.getUTCMinutes() - e._tzm),
                            (m(e).rfc2822 = !0)))
                : (e._isValid = !1);
        }
        function Ct(e) {
            if (e._f !== f.ISO_8601)
                if (e._f !== f.RFC_2822) {
                    (e._a = []), (m(e).empty = !0);
                    for (var t, i, n, s, a, o = "" + e._i, r = o.length, l = 0, d = B(e._f, e._locale).match(N) || [], c = 0; c < d.length; c++)
                        (i = d[c]),
                        (t = (o.match(de(i, e)) || [])[0]) && (0 < (s = o.substr(0, o.indexOf(t))).length && m(e).unusedInput.push(s), (o = o.slice(o.indexOf(t) + t.length)), (l += t.length)),
                            H[i] ? (t ? (m(e).empty = !1) : m(e).unusedTokens.push(i), (n = i), (a = e), null != (s = t) && u(ue, n) && ue[n](s, a._a, a, n)) : e._strict && !t && m(e).unusedTokens.push(i);
                    (m(e).charsLeftOver = r - l),
                    0 < o.length && m(e).unusedInput.push(o),
                    e._a[ge] <= 12 && !0 === m(e).bigHour && 0 < e._a[ge] && (m(e).bigHour = void 0),
                        (m(e).parsedDateParts = e._a.slice(0)),
                        (m(e).meridiem = e._meridiem),
                        (e._a[ge] = (function (e, t, i) {
                            if (null == i) return t;
                            return null != e.meridiemHour ? e.meridiemHour(t, i) : (null != e.isPM && ((i = e.isPM(i)) && t < 12 && (t += 12), i || 12 !== t || (t = 0)), t);
                        })(e._locale, e._a[ge], e._meridiem)),
                        ht(e),
                        ct(e);
                } else xt(e);
            else yt(e);
        }
        function St(e) {
            var t = e._i,
                i = e._f;
            return (
                (e._locale = e._locale || dt(e._l)),
                    null === t || (void 0 === i && "" === t)
                        ? v({ nullInput: !0 })
                        : ("string" == typeof t && (e._i = t = e._locale.preparse(t)),
                            b(t)
                                ? new y(ct(t))
                                : (s(t)
                                    ? (e._d = t)
                                    : o(i)
                                        ? (function (e) {
                                            var t, i, n, s, a;
                                            if (0 === e._f.length) return (m(e).invalidFormat = !0), (e._d = new Date(NaN));
                                            for (s = 0; s < e._f.length; s++)
                                                (a = 0),
                                                    (t = w({}, e)),
                                                null != e._useUTC && (t._useUTC = e._useUTC),
                                                    (t._f = e._f[s]),
                                                    Ct(t),
                                                p(t) && ((a += m(t).charsLeftOver), (a += 10 * m(t).unusedTokens.length), (m(t).score = a), (null == n || a < n) && ((n = a), (i = t)));
                                            c(e, i || t);
                                        })(e)
                                        : i
                                            ? Ct(e)
                                            : a((i = (t = e)._i))
                                                ? (t._d = new Date(f.now()))
                                                : s(i)
                                                    ? (t._d = new Date(i.valueOf()))
                                                    : "string" == typeof i
                                                        ? (function (e) {
                                                            var t = wt.exec(e._i);
                                                            null === t ? (yt(e), !1 === e._isValid && (delete e._isValid, xt(e), !1 === e._isValid && (delete e._isValid, f.createFromInputFallback(e)))) : (e._d = new Date(+t[1]));
                                                        })(t)
                                                        : o(i)
                                                            ? ((t._a = d(i.slice(0), function (e) {
                                                                return parseInt(e, 10);
                                                            })),
                                                                ht(t))
                                                            : r(i)
                                                                ? (function (e) {
                                                                    var t;
                                                                    e._d ||
                                                                    ((t = A(e._i)),
                                                                        (e._a = d([t.year, t.month, t.day || t.date, t.hour, t.minute, t.second, t.millisecond], function (e) {
                                                                            return e && parseInt(e, 10);
                                                                        })),
                                                                        ht(e));
                                                                })(t)
                                                                : l(i)
                                                                    ? (t._d = new Date(i))
                                                                    : f.createFromInputFallback(t),
                                p(e) || (e._d = null),
                                    e))
            );
        }
        function Tt(e, t, i, n, s) {
            var a = {};
            return (
                (!0 !== i && !1 !== i) || ((n = i), (i = void 0)),
                ((r(e) &&
                        (function (e) {
                            if (Object.getOwnPropertyNames) return 0 === Object.getOwnPropertyNames(e).length;
                            for (var t in e) if (e.hasOwnProperty(t)) return;
                            return 1;
                        })(e)) ||
                    (o(e) && 0 === e.length)) &&
                (e = void 0),
                    (a._isAMomentObject = !0),
                    (a._useUTC = a._isUTC = s),
                    (a._l = i),
                    (a._i = e),
                    (a._f = t),
                    (a._strict = n),
                (a = new y(ct(St((a = a)))))._nextDay && (a.add(1, "d"), (a._nextDay = void 0)),
                    a
            );
        }
        function $t(e, t, i, n) {
            return Tt(e, t, i, n, !1);
        }
        (f.createFromInputFallback = i(
            "value provided is not in a recognized RFC2822 or ISO format. moment construction falls back to js Date(), which is not reliable across all browsers and versions. Non RFC2822/ISO date formats are discouraged and will be removed in an upcoming major release. Please refer to http://momentjs.com/guides/#/warnings/js-date/ for more info.",
            function (e) {
                e._d = new Date(e._i + (e._useUTC ? " UTC" : ""));
            }
        )),
            (f.ISO_8601 = function () {}),
            (f.RFC_2822 = function () {});
        var Et = i("moment().min is deprecated, use moment.max instead. http://momentjs.com/guides/#/warnings/min-max/", function () {
                var e = $t.apply(null, arguments);
                return this.isValid() && e.isValid() ? (e < this ? this : e) : v();
            }),
            Dt = i("moment().max is deprecated, use moment.min instead. http://momentjs.com/guides/#/warnings/min-max/", function () {
                var e = $t.apply(null, arguments);
                return this.isValid() && e.isValid() ? (this < e ? this : e) : v();
            });
        function Mt(e, t) {
            var i, n;
            if ((1 === t.length && o(t[0]) && (t = t[0]), !t.length)) return $t();
            for (i = t[0], n = 1; n < t.length; ++n) (t[n].isValid() && !t[n][e](i)) || (i = t[n]);
            return i;
        }
        var Ot = ["year", "quarter", "month", "week", "day", "hour", "minute", "second", "millisecond"];
        function It(e) {
            var t = A(e),
                i = t.year || 0,
                n = t.quarter || 0,
                s = t.month || 0,
                a = t.week || 0,
                o = t.day || 0,
                r = t.hour || 0,
                l = t.minute || 0,
                d = t.second || 0,
                e = t.millisecond || 0;
            (this._isValid = (function (e) {
                for (var t in e) if (-1 === Se.call(Ot, t) || (null != e[t] && isNaN(e[t]))) return !1;
                for (var i = !1, n = 0; n < Ot.length; ++n)
                    if (e[Ot[n]]) {
                        if (i) return !1;
                        parseFloat(e[Ot[n]]) !== k(e[Ot[n]]) && (i = !0);
                    }
                return !0;
            })(t)),
                (this._milliseconds = +e + 1e3 * d + 6e4 * l + 1e3 * r * 60 * 60),
                (this._days = +o + 7 * a),
                (this._months = +s + 3 * n + 12 * i),
                (this._data = {}),
                (this._locale = dt()),
                this._bubble();
        }
        function Pt(e) {
            return e instanceof It;
        }
        function At(e) {
            return e < 0 ? -1 * Math.round(-1 * e) : Math.round(e);
        }
        function zt(e, i) {
            R(e, 0, 0, function () {
                var e = this.utcOffset(),
                    t = "+";
                return e < 0 && ((e = -e), (t = "-")), t + W(~~(e / 60), 2) + i + W(~~e % 60, 2);
            });
        }
        zt("Z", ":"),
            zt("ZZ", ""),
            le("Z", ae),
            le("ZZ", ae),
            he(["Z", "ZZ"], function (e, t, i) {
                (i._useUTC = !0), (i._tzm = Wt(ae, e));
            });
        var Lt = /([\+\-]|\d\d)/gi;
        function Wt(e, t) {
            t = (t || "").match(e);
            if (null === t) return null;
            (e = ((t[t.length - 1] || []) + "").match(Lt) || ["-", 0, 0]), (t = 60 * e[1] + k(e[2]));
            return 0 === t ? 0 : "+" === e[0] ? t : -t;
        }
        function Nt(e, t) {
            var i;
            return t._isUTC ? ((i = t.clone()), (t = (b(e) || s(e) ? e : $t(e)).valueOf() - i.valueOf()), i._d.setTime(i._d.valueOf() + t), f.updateOffset(i, !1), i) : $t(e).local();
        }
        function Yt(e) {
            return 15 * -Math.round(e._d.getTimezoneOffset() / 15);
        }
        function jt() {
            return !!this.isValid() && this._isUTC && 0 === this._offset;
        }
        f.updateOffset = function () {};
        var Ht = /^(\-|\+)?(?:(\d*)[. ])?(\d+)\:(\d+)(?:\:(\d+)(\.\d*)?)?$/,
            Rt = /^(-|\+)?P(?:([-+]?[0-9,.]*)Y)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)W)?(?:([-+]?[0-9,.]*)D)?(?:T(?:([-+]?[0-9,.]*)H)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)S)?)?$/;
        function Ft(e, t) {
            var i,
                n = e,
                s = null;
            return (
                Pt(e)
                    ? (n = { ms: e._milliseconds, d: e._days, M: e._months })
                    : l(e)
                        ? ((n = {}), t ? (n[t] = e) : (n.milliseconds = e))
                        : (s = Ht.exec(e))
                            ? ((i = "-" === s[1] ? -1 : 1), (n = { y: 0, d: k(s[ve]) * i, h: k(s[ge]) * i, m: k(s[we]) * i, s: k(s[ye]) * i, ms: k(At(1e3 * s[be])) * i }))
                            : (s = Rt.exec(e))
                                ? ((i = "-" === s[1] ? -1 : (s[1], 1)), (n = { y: Bt(s[2], i), M: Bt(s[3], i), w: Bt(s[4], i), d: Bt(s[5], i), h: Bt(s[6], i), m: Bt(s[7], i), s: Bt(s[8], i) }))
                                : null == n
                                    ? (n = {})
                                    : "object" == typeof n &&
                                    ("from" in n || "to" in n) &&
                                    ((i = (function (e, t) {
                                        var i;
                                        if (!e.isValid() || !t.isValid()) return { milliseconds: 0, months: 0 };
                                        (t = Nt(t, e)), e.isBefore(t) ? (i = Vt(e, t)) : (((i = Vt(t, e)).milliseconds = -i.milliseconds), (i.months = -i.months));
                                        return i;
                                    })($t(n.from), $t(n.to))),
                                        ((n = {}).ms = i.milliseconds),
                                        (n.M = i.months)),
                    (n = new It(n)),
                Pt(e) && u(e, "_locale") && (n._locale = e._locale),
                    n
            );
        }
        function Bt(e, t) {
            e = e && parseFloat(e.replace(",", "."));
            return (isNaN(e) ? 0 : e) * t;
        }
        function Vt(e, t) {
            var i = { milliseconds: 0, months: 0 };
            return (i.months = t.month() - e.month() + 12 * (t.year() - e.year())), e.clone().add(i.months, "M").isAfter(t) && --i.months, (i.milliseconds = +t - +e.clone().add(i.months, "M")), i;
        }
        function Ut(n, s) {
            return function (e, t) {
                var i;
                return (
                    null === t ||
                    isNaN(+t) ||
                    ($(s, "moment()." + s + "(period, number) is deprecated. Please use moment()." + s + "(number, period). See http://momentjs.com/guides/#/warnings/add-inverted-param/ for more info."), (i = e), (e = t), (t = i)),
                        Gt(this, Ft((e = "string" == typeof e ? +e : e), t), n),
                        this
                );
            };
        }
        function Gt(e, t, i, n) {
            var s = t._milliseconds,
                a = At(t._days),
                t = At(t._months);
            e.isValid() && ((n = null == n || n), t && Ae(e, Ee(e, "Month") + t * i), a && De(e, "Date", Ee(e, "Date") + a * i), s && e._d.setTime(e._d.valueOf() + s * i), n && f.updateOffset(e, a || t));
        }
        (Ft.fn = It.prototype),
            (Ft.invalid = function () {
                return Ft(NaN);
            });
        (oe = Ut(1, "add")), (K = Ut(-1, "subtract"));
        function qt(e, t) {
            var i = 12 * (t.year() - e.year()) + (t.month() - e.month()),
                n = e.clone().add(i, "months"),
                n = t - n < 0 ? (t - n) / (n - e.clone().add(i - 1, "months")) : (t - n) / (e.clone().add(1 + i, "months") - n);
            return -(i + n) || 0;
        }
        function Xt(e) {
            return void 0 === e ? this._locale._abbr : (null != (e = dt(e)) && (this._locale = e), this);
        }
        (f.defaultFormat = "YYYY-MM-DDTHH:mm:ssZ"), (f.defaultFormatUtc = "YYYY-MM-DDTHH:mm:ss[Z]");
        Q = i("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.", function (e) {
            return void 0 === e ? this.localeData() : this.locale(e);
        });
        function Zt() {
            return this._locale;
        }
        function Kt(e, t) {
            R(0, [e, e.length], 0, t);
        }
        function Qt(e, t, i, n, s) {
            var a;
            return null == e
                ? Re(this, n, s).year
                : ((a = Fe(e, n, s)) < t && (t = a),
                    function (e, t, i, n, s) {
                        (s = He(e, t, i, n, s)), (s = Ye(s.year, 0, s.dayOfYear));
                        return this.year(s.getUTCFullYear()), this.month(s.getUTCMonth()), this.date(s.getUTCDate()), this;
                    }.call(this, e, t, i, n, s));
        }
        R(0, ["gg", 2], 0, function () {
            return this.weekYear() % 100;
        }),
            R(0, ["GG", 2], 0, function () {
                return this.isoWeekYear() % 100;
            }),
            Kt("gggg", "weekYear"),
            Kt("ggggg", "weekYear"),
            Kt("GGGG", "isoWeekYear"),
            Kt("GGGGG", "isoWeekYear"),
            I("weekYear", "gg"),
            I("isoWeekYear", "GG"),
            L("weekYear", 1),
            L("isoWeekYear", 1),
            le("G", ne),
            le("g", ne),
            le("GG", Z, U),
            le("gg", Z, U),
            le("GGGG", ee, q),
            le("gggg", ee, q),
            le("GGGGG", te, X),
            le("ggggg", te, X),
            pe(["gggg", "ggggg", "GGGG", "GGGGG"], function (e, t, i, n) {
                t[n.substr(0, 2)] = k(e);
            }),
            pe(["gg", "GG"], function (e, t, i, n) {
                t[n] = f.parseTwoDigitYear(e);
            }),
            R("Q", 0, "Qo", "quarter"),
            I("quarter", "Q"),
            L("quarter", 7),
            le("Q", V),
            he("Q", function (e, t) {
                t[me] = 3 * (k(e) - 1);
            }),
            R("D", ["DD", 2], "Do", "date"),
            I("date", "D"),
            L("date", 9),
            le("D", Z),
            le("DD", Z, U),
            le("Do", function (e, t) {
                return e ? t._dayOfMonthOrdinalParse || t._ordinalParse : t._dayOfMonthOrdinalParseLenient;
            }),
            he(["D", "DD"], ve),
            he("Do", function (e, t) {
                t[ve] = k(e.match(Z)[0]);
            });
        Ie = $e("Date", !0);
        R("DDD", ["DDDD", 3], "DDDo", "dayOfYear"),
            I("dayOfYear", "DDD"),
            L("dayOfYear", 4),
            le("DDD", J),
            le("DDDD", G),
            he(["DDD", "DDDD"], function (e, t, i) {
                i._dayOfYear = k(e);
            }),
            R("m", ["mm", 2], 0, "minute"),
            I("minute", "m"),
            L("minute", 14),
            le("m", Z),
            le("mm", Z, U),
            he(["m", "mm"], we);
        Be = $e("Minutes", !1);
        R("s", ["ss", 2], 0, "second"), I("second", "s"), L("second", 15), le("s", Z), le("ss", Z, U), he(["s", "ss"], ye);
        var Jt,
            Ue = $e("Seconds", !1);
        for (
            R("S", 0, 0, function () {
                return ~~(this.millisecond() / 100);
            }),
                R(0, ["SS", 2], 0, function () {
                    return ~~(this.millisecond() / 10);
                }),
                R(0, ["SSS", 3], 0, "millisecond"),
                R(0, ["SSSS", 4], 0, function () {
                    return 10 * this.millisecond();
                }),
                R(0, ["SSSSS", 5], 0, function () {
                    return 100 * this.millisecond();
                }),
                R(0, ["SSSSSS", 6], 0, function () {
                    return 1e3 * this.millisecond();
                }),
                R(0, ["SSSSSSS", 7], 0, function () {
                    return 1e4 * this.millisecond();
                }),
                R(0, ["SSSSSSSS", 8], 0, function () {
                    return 1e5 * this.millisecond();
                }),
                R(0, ["SSSSSSSSS", 9], 0, function () {
                    return 1e6 * this.millisecond();
                }),
                I("millisecond", "ms"),
                L("millisecond", 16),
                le("S", J, V),
                le("SS", J, U),
                le("SSS", J, G),
                Jt = "SSSS";
            Jt.length <= 9;
            Jt += "S"
        )
            le(Jt, ie);
        function ei(e, t) {
            t[be] = k(1e3 * ("0." + e));
        }
        for (Jt = "S"; Jt.length <= 9; Jt += "S") he(Jt, ei);
        ee = $e("Milliseconds", !1);
        R("z", 0, 0, "zoneAbbr"), R("zz", 0, 0, "zoneName");
        q = y.prototype;
        function ti(e) {
            return e;
        }
        (q.add = oe),
            (q.calendar = function (e, t) {
                var i = e || $t(),
                    e = Nt(i, this).startOf("day"),
                    e = f.calendarFormat(this, e) || "sameElse",
                    t = t && (E(t[e]) ? t[e].call(this, i) : t[e]);
                return this.format(t || this.localeData().calendar(e, this, $t(i)));
            }),
            (q.clone = function () {
                return new y(this);
            }),
            (q.diff = function (e, t, i) {
                var n, s, a;
                if (!this.isValid()) return NaN;
                if (!(n = Nt(e, this)).isValid()) return NaN;
                switch (((s = 6e4 * (n.utcOffset() - this.utcOffset())), (t = P(t)))) {
                    case "year":
                        a = qt(this, n) / 12;
                        break;
                    case "month":
                        a = qt(this, n);
                        break;
                    case "quarter":
                        a = qt(this, n) / 3;
                        break;
                    case "second":
                        a = (this - n) / 1e3;
                        break;
                    case "minute":
                        a = (this - n) / 6e4;
                        break;
                    case "hour":
                        a = (this - n) / 36e5;
                        break;
                    case "day":
                        a = (this - n - s) / 864e5;
                        break;
                    case "week":
                        a = (this - n - s) / 6048e5;
                        break;
                    default:
                        a = this - n;
                }
                return i ? a : _(a);
            }),
            (q.endOf = function (e) {
                return void 0 === (e = P(e)) || "millisecond" === e
                    ? this
                    : ("date" === e && (e = "day"),
                        this.startOf(e)
                            .add(1, "isoWeek" === e ? "week" : e)
                            .subtract(1, "ms"));
            }),
            (q.format = function (e) {
                return (e = e || (this.isUtc() ? f.defaultFormatUtc : f.defaultFormat)), (e = F(this, e)), this.localeData().postformat(e);
            }),
            (q.from = function (e, t) {
                return this.isValid() && ((b(e) && e.isValid()) || $t(e).isValid()) ? Ft({ to: this, from: e }).locale(this.locale()).humanize(!t) : this.localeData().invalidDate();
            }),
            (q.fromNow = function (e) {
                return this.from($t(), e);
            }),
            (q.to = function (e, t) {
                return this.isValid() && ((b(e) && e.isValid()) || $t(e).isValid()) ? Ft({ from: this, to: e }).locale(this.locale()).humanize(!t) : this.localeData().invalidDate();
            }),
            (q.toNow = function (e) {
                return this.to($t(), e);
            }),
            (q.get = function (e) {
                return E(this[(e = P(e))]) ? this[e]() : this;
            }),
            (q.invalidAt = function () {
                return m(this).overflow;
            }),
            (q.isAfter = function (e, t) {
                return (e = b(e) ? e : $t(e)), !(!this.isValid() || !e.isValid()) && ("millisecond" === (t = P(a(t) ? "millisecond" : t)) ? this.valueOf() > e.valueOf() : e.valueOf() < this.clone().startOf(t).valueOf());
            }),
            (q.isBefore = function (e, t) {
                return (e = b(e) ? e : $t(e)), !(!this.isValid() || !e.isValid()) && ("millisecond" === (t = P(a(t) ? "millisecond" : t)) ? this.valueOf() < e.valueOf() : this.clone().endOf(t).valueOf() < e.valueOf());
            }),
            (q.isBetween = function (e, t, i, n) {
                return ("(" === (n = n || "()")[0] ? this.isAfter(e, i) : !this.isBefore(e, i)) && (")" === n[1] ? this.isBefore(t, i) : !this.isAfter(t, i));
            }),
            (q.isSame = function (e, t) {
                return (
                    (e = b(e) ? e : $t(e)),
                    !(!this.isValid() || !e.isValid()) && ("millisecond" === (t = P(t || "millisecond")) ? this.valueOf() === e.valueOf() : ((e = e.valueOf()), this.clone().startOf(t).valueOf() <= e && e <= this.clone().endOf(t).valueOf()))
                );
            }),
            (q.isSameOrAfter = function (e, t) {
                return this.isSame(e, t) || this.isAfter(e, t);
            }),
            (q.isSameOrBefore = function (e, t) {
                return this.isSame(e, t) || this.isBefore(e, t);
            }),
            (q.isValid = function () {
                return p(this);
            }),
            (q.lang = Q),
            (q.locale = Xt),
            (q.localeData = Zt),
            (q.max = Dt),
            (q.min = Et),
            (q.parsingFlags = function () {
                return c({}, m(this));
            }),
            (q.set = function (e, t) {
                if ("object" == typeof e)
                    for (
                        var i = (function (e) {
                                var t,
                                    i = [];
                                for (t in e) i.push({ unit: t, priority: z[t] });
                                return (
                                    i.sort(function (e, t) {
                                        return e.priority - t.priority;
                                    }),
                                        i
                                );
                            })((e = A(e))),
                            n = 0;
                        n < i.length;
                        n++
                    )
                        this[i[n].unit](e[i[n].unit]);
                else if (E(this[(e = P(e))])) return this[e](t);
                return this;
            }),
            (q.startOf = function (e) {
                switch ((e = P(e))) {
                    case "year":
                        this.month(0);
                    case "quarter":
                    case "month":
                        this.date(1);
                    case "week":
                    case "isoWeek":
                    case "day":
                    case "date":
                        this.hours(0);
                    case "hour":
                        this.minutes(0);
                    case "minute":
                        this.seconds(0);
                    case "second":
                        this.milliseconds(0);
                }
                return "week" === e && this.weekday(0), "isoWeek" === e && this.isoWeekday(1), "quarter" === e && this.month(3 * Math.floor(this.month() / 3)), this;
            }),
            (q.subtract = K),
            (q.toArray = function () {
                return [this.year(), this.month(), this.date(), this.hour(), this.minute(), this.second(), this.millisecond()];
            }),
            (q.toObject = function () {
                return { years: this.year(), months: this.month(), date: this.date(), hours: this.hours(), minutes: this.minutes(), seconds: this.seconds(), milliseconds: this.milliseconds() };
            }),
            (q.toDate = function () {
                return new Date(this.valueOf());
            }),
            (q.toISOString = function (e) {
                if (!this.isValid()) return null;
                var t = !0 !== e;
                return (e = t ? this.clone().utc() : this).year() < 0 || 9999 < e.year()
                    ? F(e, t ? "YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]" : "YYYYYY-MM-DD[T]HH:mm:ss.SSSZ")
                    : E(Date.prototype.toISOString)
                        ? t
                            ? this.toDate().toISOString()
                            : new Date(this.valueOf() + 60 * this.utcOffset() * 1e3).toISOString().replace("Z", F(e, "Z"))
                        : F(e, t ? "YYYY-MM-DD[T]HH:mm:ss.SSS[Z]" : "YYYY-MM-DD[T]HH:mm:ss.SSSZ");
            }),
            (q.inspect = function () {
                if (!this.isValid()) return "moment.invalid(/* " + this._i + " */)";
                var e = "moment",
                    t = "";
                this.isLocal() || ((e = 0 === this.utcOffset() ? "moment.utc" : "moment.parseZone"), (t = "Z"));
                var i = "[" + e + '("]',
                    e = 0 <= this.year() && this.year() <= 9999 ? "YYYY" : "YYYYYY",
                    t = t + '[")]';
                return this.format(i + e + "-MM-DD[T]HH:mm:ss.SSS" + t);
            }),
            (q.toJSON = function () {
                return this.isValid() ? this.toISOString() : null;
            }),
            (q.toString = function () {
                return this.clone().locale("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ");
            }),
            (q.unix = function () {
                return Math.floor(this.valueOf() / 1e3);
            }),
            (q.valueOf = function () {
                return this._d.valueOf() - 6e4 * (this._offset || 0);
            }),
            (q.creationData = function () {
                return { input: this._i, format: this._f, locale: this._locale, isUTC: this._isUTC, strict: this._strict };
            }),
            (q.year = Te),
            (q.isLeapYear = function () {
                return Ce(this.year());
            }),
            (q.weekYear = function (e) {
                return Qt.call(this, e, this.week(), this.weekday(), this.localeData()._week.dow, this.localeData()._week.doy);
            }),
            (q.isoWeekYear = function (e) {
                return Qt.call(this, e, this.isoWeek(), this.isoWeekday(), 1, 4);
            }),
            (q.quarter = q.quarters = function (e) {
                return null == e ? Math.ceil((this.month() + 1) / 3) : this.month(3 * (e - 1) + (this.month() % 3));
            }),
            (q.month = ze),
            (q.daysInMonth = function () {
                return Me(this.year(), this.month());
            }),
            (q.week = q.weeks = function (e) {
                var t = this.localeData().week(this);
                return null == e ? t : this.add(7 * (e - t), "d");
            }),
            (q.isoWeek = q.isoWeeks = function (e) {
                var t = Re(this, 1, 4).week;
                return null == e ? t : this.add(7 * (e - t), "d");
            }),
            (q.weeksInYear = function () {
                var e = this.localeData()._week;
                return Fe(this.year(), e.dow, e.doy);
            }),
            (q.isoWeeksInYear = function () {
                return Fe(this.year(), 1, 4);
            }),
            (q.date = Ie),
            (q.day = q.days = function (e) {
                if (!this.isValid()) return null != e ? this : NaN;
                var t,
                    i,
                    n = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
                return null != e ? ((t = e), (i = this.localeData()), (e = "string" != typeof t ? t : isNaN(t) ? ("number" == typeof (t = i.weekdaysParse(t)) ? t : null) : parseInt(t, 10)), this.add(e - n, "d")) : n;
            }),
            (q.weekday = function (e) {
                if (!this.isValid()) return null != e ? this : NaN;
                var t = (this.day() + 7 - this.localeData()._week.dow) % 7;
                return null == e ? t : this.add(e - t, "d");
            }),
            (q.isoWeekday = function (e) {
                if (!this.isValid()) return null != e ? this : NaN;
                if (null == e) return this.day() || 7;
                var t = ((t = e), (e = this.localeData()), "string" == typeof t ? e.weekdaysParse(t) % 7 || 7 : isNaN(t) ? null : t);
                return this.day(this.day() % 7 ? t : t - 7);
            }),
            (q.dayOfYear = function (e) {
                var t = Math.round((this.clone().startOf("day") - this.clone().startOf("year")) / 864e5) + 1;
                return null == e ? t : this.add(e - t, "d");
            }),
            (q.hour = q.hours = tt),
            (q.minute = q.minutes = Be),
            (q.second = q.seconds = Ue),
            (q.millisecond = q.milliseconds = ee),
            (q.utcOffset = function (e, t, i) {
                var n,
                    s = this._offset || 0;
                if (!this.isValid()) return null != e ? this : NaN;
                if (null == e) return this._isUTC ? s : Yt(this);
                if ("string" == typeof e) {
                    if (null === (e = Wt(ae, e))) return this;
                } else Math.abs(e) < 16 && !i && (e *= 60);
                return (
                    !this._isUTC && t && (n = Yt(this)),
                        (this._offset = e),
                        (this._isUTC = !0),
                    null != n && this.add(n, "m"),
                    s !== e && (!t || this._changeInProgress ? Gt(this, Ft(e - s, "m"), 1, !1) : this._changeInProgress || ((this._changeInProgress = !0), f.updateOffset(this, !0), (this._changeInProgress = null))),
                        this
                );
            }),
            (q.utc = function (e) {
                return this.utcOffset(0, e);
            }),
            (q.local = function (e) {
                return this._isUTC && (this.utcOffset(0, e), (this._isUTC = !1), e && this.subtract(Yt(this), "m")), this;
            }),
            (q.parseZone = function () {
                var e;
                return null != this._tzm ? this.utcOffset(this._tzm, !1, !0) : "string" == typeof this._i && (null != (e = Wt(se, this._i)) ? this.utcOffset(e) : this.utcOffset(0, !0)), this;
            }),
            (q.hasAlignedHourOffset = function (e) {
                return !!this.isValid() && ((e = e ? $t(e).utcOffset() : 0), (this.utcOffset() - e) % 60 == 0);
            }),
            (q.isDST = function () {
                return this.utcOffset() > this.clone().month(0).utcOffset() || this.utcOffset() > this.clone().month(5).utcOffset();
            }),
            (q.isLocal = function () {
                return !!this.isValid() && !this._isUTC;
            }),
            (q.isUtcOffset = function () {
                return !!this.isValid() && this._isUTC;
            }),
            (q.isUtc = jt),
            (q.isUTC = jt),
            (q.zoneAbbr = function () {
                return this._isUTC ? "UTC" : "";
            }),
            (q.zoneName = function () {
                return this._isUTC ? "Coordinated Universal Time" : "";
            }),
            (q.dates = i("dates accessor is deprecated. Use date instead.", Ie)),
            (q.months = i("months accessor is deprecated. Use month instead", ze)),
            (q.years = i("years accessor is deprecated. Use year instead", Te)),
            (q.zone = i("moment().zone is deprecated, use moment().utcOffset instead. http://momentjs.com/guides/#/warnings/zone/", function (e, t) {
                return null != e ? ("string" != typeof e && (e = -e), this.utcOffset(e, t), this) : -this.utcOffset();
            })),
            (q.isDSTShifted = i("isDSTShifted is deprecated. See http://momentjs.com/guides/#/warnings/dst-shifted/ for more information", function () {
                if (!a(this._isDSTShifted)) return this._isDSTShifted;
                var e,
                    t = {};
                return w(t, this), (t = St(t))._a ? ((e = (t._isUTC ? h : $t)(t._a)), (this._isDSTShifted = this.isValid() && 0 < x(t._a, e.toArray()))) : (this._isDSTShifted = !1), this._isDSTShifted;
            }));
        te = M.prototype;
        function ii(e, t, i, n) {
            var s = dt(),
                t = h().set(n, t);
            return s[i](t, e);
        }
        function ni(e, t, i) {
            if ((l(e) && ((t = e), (e = void 0)), (e = e || ""), null != t)) return ii(e, t, i, "month");
            for (var n = [], s = 0; s < 12; s++) n[s] = ii(e, s, i, "month");
            return n;
        }
        function si(e, t, i, n) {
            t = ("boolean" == typeof e ? l(t) && ((i = t), (t = void 0)) : ((t = e), (e = !1), l((i = t)) && ((i = t), (t = void 0))), t || "");
            var s = dt(),
                a = e ? s._week.dow : 0;
            if (null != i) return ii(t, (i + a) % 7, n, "day");
            for (var o = [], r = 0; r < 7; r++) o[r] = ii(t, (r + a) % 7, n, "day");
            return o;
        }
        (te.calendar = function (e, t, i) {
            return E((e = this._calendar[e] || this._calendar.sameElse)) ? e.call(t, i) : e;
        }),
            (te.longDateFormat = function (e) {
                var t = this._longDateFormat[e],
                    i = this._longDateFormat[e.toUpperCase()];
                return t || !i
                    ? t
                    : ((this._longDateFormat[e] = i.replace(/MMMM|MM|DD|dddd/g, function (e) {
                        return e.slice(1);
                    })),
                        this._longDateFormat[e]);
            }),
            (te.invalidDate = function () {
                return this._invalidDate;
            }),
            (te.ordinal = function (e) {
                return this._ordinal.replace("%d", e);
            }),
            (te.preparse = ti),
            (te.postformat = ti),
            (te.relativeTime = function (e, t, i, n) {
                var s = this._relativeTime[i];
                return E(s) ? s(e, t, i, n) : s.replace(/%d/i, e);
            }),
            (te.pastFuture = function (e, t) {
                return E((e = this._relativeTime[0 < e ? "future" : "past"])) ? e(t) : e.replace(/%s/i, t);
            }),
            (te.set = function (e) {
                var t, i;
                for (i in e) E((t = e[i])) ? (this[i] = t) : (this["_" + i] = t);
                (this._config = e), (this._dayOfMonthOrdinalParseLenient = new RegExp((this._dayOfMonthOrdinalParse.source || this._ordinalParse.source) + "|" + /\d{1,2}/.source));
            }),
            (te.months = function (e, t) {
                return e ? (o(this._months) ? this._months : this._months[(this._months.isFormat || Oe).test(t) ? "format" : "standalone"])[e.month()] : o(this._months) ? this._months : this._months.standalone;
            }),
            (te.monthsShort = function (e, t) {
                return e ? (o(this._monthsShort) ? this._monthsShort : this._monthsShort[Oe.test(t) ? "format" : "standalone"])[e.month()] : o(this._monthsShort) ? this._monthsShort : this._monthsShort.standalone;
            }),
            (te.monthsParse = function (e, t, i) {
                var n, s;
                if (this._monthsParseExact)
                    return function (e, t, i) {
                        var n,
                            s,
                            a,
                            e = e.toLocaleLowerCase();
                        if (!this._monthsParse)
                            for (this._monthsParse = [], this._longMonthsParse = [], this._shortMonthsParse = [], n = 0; n < 12; ++n)
                                (a = h([2e3, n])), (this._shortMonthsParse[n] = this.monthsShort(a, "").toLocaleLowerCase()), (this._longMonthsParse[n] = this.months(a, "").toLocaleLowerCase());
                        return i
                            ? "MMM" === t
                                ? -1 !== (s = Se.call(this._shortMonthsParse, e))
                                    ? s
                                    : null
                                : -1 !== (s = Se.call(this._longMonthsParse, e))
                                    ? s
                                    : null
                            : "MMM" === t
                                ? -1 !== (s = Se.call(this._shortMonthsParse, e)) || -1 !== (s = Se.call(this._longMonthsParse, e))
                                    ? s
                                    : null
                                : -1 !== (s = Se.call(this._longMonthsParse, e)) || -1 !== (s = Se.call(this._shortMonthsParse, e))
                                    ? s
                                    : null;
                    }.call(this, e, t, i);
                for (this._monthsParse || ((this._monthsParse = []), (this._longMonthsParse = []), (this._shortMonthsParse = [])), n = 0; n < 12; n++) {
                    if (
                        ((s = h([2e3, n])),
                        i &&
                        !this._longMonthsParse[n] &&
                        ((this._longMonthsParse[n] = new RegExp("^" + this.months(s, "").replace(".", "") + "$", "i")), (this._shortMonthsParse[n] = new RegExp("^" + this.monthsShort(s, "").replace(".", "") + "$", "i"))),
                        i || this._monthsParse[n] || ((s = "^" + this.months(s, "") + "|^" + this.monthsShort(s, "")), (this._monthsParse[n] = new RegExp(s.replace(".", ""), "i"))),
                        i && "MMMM" === t && this._longMonthsParse[n].test(e))
                    )
                        return n;
                    if (i && "MMM" === t && this._shortMonthsParse[n].test(e)) return n;
                    if (!i && this._monthsParse[n].test(e)) return n;
                }
            }),
            (te.monthsRegex = function (e) {
                return this._monthsParseExact
                    ? (u(this, "_monthsRegex") || Ne.call(this), e ? this._monthsStrictRegex : this._monthsRegex)
                    : (u(this, "_monthsRegex") || (this._monthsRegex = We), this._monthsStrictRegex && e ? this._monthsStrictRegex : this._monthsRegex);
            }),
            (te.monthsShortRegex = function (e) {
                return this._monthsParseExact
                    ? (u(this, "_monthsRegex") || Ne.call(this), e ? this._monthsShortStrictRegex : this._monthsShortRegex)
                    : (u(this, "_monthsShortRegex") || (this._monthsShortRegex = Le), this._monthsShortStrictRegex && e ? this._monthsShortStrictRegex : this._monthsShortRegex);
            }),
            (te.week = function (e) {
                return Re(e, this._week.dow, this._week.doy).week;
            }),
            (te.firstDayOfYear = function () {
                return this._week.doy;
            }),
            (te.firstDayOfWeek = function () {
                return this._week.dow;
            }),
            (te.weekdays = function (e, t) {
                return e ? (o(this._weekdays) ? this._weekdays : this._weekdays[this._weekdays.isFormat.test(t) ? "format" : "standalone"])[e.day()] : o(this._weekdays) ? this._weekdays : this._weekdays.standalone;
            }),
            (te.weekdaysMin = function (e) {
                return e ? this._weekdaysMin[e.day()] : this._weekdaysMin;
            }),
            (te.weekdaysShort = function (e) {
                return e ? this._weekdaysShort[e.day()] : this._weekdaysShort;
            }),
            (te.weekdaysParse = function (e, t, i) {
                var n, s;
                if (this._weekdaysParseExact)
                    return function (e, t, i) {
                        var n,
                            s,
                            a,
                            e = e.toLocaleLowerCase();
                        if (!this._weekdaysParse)
                            for (this._weekdaysParse = [], this._shortWeekdaysParse = [], this._minWeekdaysParse = [], n = 0; n < 7; ++n)
                                (a = h([2e3, 1]).day(n)),
                                    (this._minWeekdaysParse[n] = this.weekdaysMin(a, "").toLocaleLowerCase()),
                                    (this._shortWeekdaysParse[n] = this.weekdaysShort(a, "").toLocaleLowerCase()),
                                    (this._weekdaysParse[n] = this.weekdays(a, "").toLocaleLowerCase());
                        return i
                            ? "dddd" === t
                                ? -1 !== (s = Se.call(this._weekdaysParse, e))
                                    ? s
                                    : null
                                : "ddd" === t
                                    ? -1 !== (s = Se.call(this._shortWeekdaysParse, e))
                                        ? s
                                        : null
                                    : -1 !== (s = Se.call(this._minWeekdaysParse, e))
                                        ? s
                                        : null
                            : "dddd" === t
                                ? -1 !== (s = Se.call(this._weekdaysParse, e)) || -1 !== (s = Se.call(this._shortWeekdaysParse, e)) || -1 !== (s = Se.call(this._minWeekdaysParse, e))
                                    ? s
                                    : null
                                : "ddd" === t
                                    ? -1 !== (s = Se.call(this._shortWeekdaysParse, e)) || -1 !== (s = Se.call(this._weekdaysParse, e)) || -1 !== (s = Se.call(this._minWeekdaysParse, e))
                                        ? s
                                        : null
                                    : -1 !== (s = Se.call(this._minWeekdaysParse, e)) || -1 !== (s = Se.call(this._weekdaysParse, e)) || -1 !== (s = Se.call(this._shortWeekdaysParse, e))
                                        ? s
                                        : null;
                    }.call(this, e, t, i);
                for (this._weekdaysParse || ((this._weekdaysParse = []), (this._minWeekdaysParse = []), (this._shortWeekdaysParse = []), (this._fullWeekdaysParse = [])), n = 0; n < 7; n++) {
                    if (
                        ((s = h([2e3, 1]).day(n)),
                        i &&
                        !this._fullWeekdaysParse[n] &&
                        ((this._fullWeekdaysParse[n] = new RegExp("^" + this.weekdays(s, "").replace(".", "\\.?") + "$", "i")),
                            (this._shortWeekdaysParse[n] = new RegExp("^" + this.weekdaysShort(s, "").replace(".", "\\.?") + "$", "i")),
                            (this._minWeekdaysParse[n] = new RegExp("^" + this.weekdaysMin(s, "").replace(".", "\\.?") + "$", "i"))),
                        this._weekdaysParse[n] || ((s = "^" + this.weekdays(s, "") + "|^" + this.weekdaysShort(s, "") + "|^" + this.weekdaysMin(s, "")), (this._weekdaysParse[n] = new RegExp(s.replace(".", ""), "i"))),
                        i && "dddd" === t && this._fullWeekdaysParse[n].test(e))
                    )
                        return n;
                    if (i && "ddd" === t && this._shortWeekdaysParse[n].test(e)) return n;
                    if (i && "dd" === t && this._minWeekdaysParse[n].test(e)) return n;
                    if (!i && this._weekdaysParse[n].test(e)) return n;
                }
            }),
            (te.weekdaysRegex = function (e) {
                return this._weekdaysParseExact
                    ? (u(this, "_weekdaysRegex") || Ze.call(this), e ? this._weekdaysStrictRegex : this._weekdaysRegex)
                    : (u(this, "_weekdaysRegex") || (this._weekdaysRegex = Ge), this._weekdaysStrictRegex && e ? this._weekdaysStrictRegex : this._weekdaysRegex);
            }),
            (te.weekdaysShortRegex = function (e) {
                return this._weekdaysParseExact
                    ? (u(this, "_weekdaysRegex") || Ze.call(this), e ? this._weekdaysShortStrictRegex : this._weekdaysShortRegex)
                    : (u(this, "_weekdaysShortRegex") || (this._weekdaysShortRegex = qe), this._weekdaysShortStrictRegex && e ? this._weekdaysShortStrictRegex : this._weekdaysShortRegex);
            }),
            (te.weekdaysMinRegex = function (e) {
                return this._weekdaysParseExact
                    ? (u(this, "_weekdaysRegex") || Ze.call(this), e ? this._weekdaysMinStrictRegex : this._weekdaysMinRegex)
                    : (u(this, "_weekdaysMinRegex") || (this._weekdaysMinRegex = Xe), this._weekdaysMinStrictRegex && e ? this._weekdaysMinStrictRegex : this._weekdaysMinRegex);
            }),
            (te.isPM = function (e) {
                return "p" === (e + "").toLowerCase().charAt(0);
            }),
            (te.meridiem = function (e, t, i) {
                return 11 < e ? (i ? "pm" : "PM") : i ? "am" : "AM";
            }),
            rt("en", {
                dayOfMonthOrdinalParse: /\d{1,2}(th|st|nd|rd)/,
                ordinal: function (e) {
                    var t = e % 10;
                    return e + (1 === k((e % 100) / 10) ? "th" : 1 == t ? "st" : 2 == t ? "nd" : 3 == t ? "rd" : "th");
                },
            }),
            (f.lang = i("moment.lang is deprecated. Use moment.locale instead.", rt)),
            (f.langData = i("moment.langData is deprecated. Use moment.localeData instead.", dt));
        var ai = Math.abs;
        function oi(e, t, i, n) {
            i = Ft(t, i);
            return (e._milliseconds += n * i._milliseconds), (e._days += n * i._days), (e._months += n * i._months), e._bubble();
        }
        function ri(e) {
            return e < 0 ? Math.floor(e) : Math.ceil(e);
        }
        function li(e) {
            return (4800 * e) / 146097;
        }
        function di(e) {
            return (146097 * e) / 4800;
        }
        function ci(e) {
            return function () {
                return this.as(e);
            };
        }
        (X = ci("ms")), (V = ci("s")), (U = ci("m")), (J = ci("h")), (G = ci("d")), (oe = ci("w")), (Dt = ci("M")), (Et = ci("y"));
        function ui(e) {
            return function () {
                return this.isValid() ? this._data[e] : NaN;
            };
        }
        (K = ui("milliseconds")), (tt = ui("seconds")), (Be = ui("minutes")), (Ue = ui("hours")), (ee = ui("days")), (Ie = ui("months")), (Te = ui("years"));
        var hi = Math.round,
            pi = { ss: 44, s: 45, m: 45, h: 22, d: 26, M: 11 };
        function fi(e, t, i) {
            var n = Ft(e).abs(),
                s = hi(n.as("s")),
                a = hi(n.as("m")),
                o = hi(n.as("h")),
                r = hi(n.as("d")),
                l = hi(n.as("M")),
                n = hi(n.as("y")),
                n = (s <= pi.ss ? ["s", s] : s < pi.s && ["ss", s]) ||
                    (a <= 1 && ["m"]) ||
                    (a < pi.m && ["mm", a]) ||
                    (o <= 1 && ["h"]) ||
                    (o < pi.h && ["hh", o]) ||
                    (r <= 1 && ["d"]) ||
                    (r < pi.d && ["dd", r]) ||
                    (l <= 1 && ["M"]) ||
                    (l < pi.M && ["MM", l]) ||
                    (n <= 1 && ["y"]) || ["yy", n];
            return (
                (n[2] = t),
                    (n[3] = 0 < +e),
                    (n[4] = i),
                    function (e, t, i, n, s) {
                        return s.relativeTime(t || 1, !!i, e, n);
                    }.apply(null, n)
            );
        }
        var mi = Math.abs;
        function vi(e) {
            return (0 < e) - (e < 0) || +e;
        }
        function gi() {
            if (!this.isValid()) return this.localeData().invalidDate();
            var e = mi(this._milliseconds) / 1e3,
                t = mi(this._days),
                i = mi(this._months),
                n = _(e / 60),
                s = _(n / 60);
            (e %= 60), (n %= 60);
            var a = _(i / 12),
                o = (i %= 12),
                r = t,
                l = s,
                d = n,
                i = e ? e.toFixed(3).replace(/\.?0+$/, "") : "",
                t = this.asSeconds();
            if (!t) return "P0D";
            (s = t < 0 ? "-" : ""), (n = vi(this._months) !== vi(t) ? "-" : ""), (e = vi(this._days) !== vi(t) ? "-" : ""), (t = vi(this._milliseconds) !== vi(t) ? "-" : "");
            return s + "P" + (a ? n + a + "Y" : "") + (o ? n + o + "M" : "") + (r ? e + r + "D" : "") + (l || d || i ? "T" : "") + (l ? t + l + "H" : "") + (d ? t + d + "M" : "") + (i ? t + i + "S" : "");
        }
        te = It.prototype;
        return (
            (te.isValid = function () {
                return this._isValid;
            }),
                (te.abs = function () {
                    var e = this._data;
                    return (
                        (this._milliseconds = ai(this._milliseconds)),
                            (this._days = ai(this._days)),
                            (this._months = ai(this._months)),
                            (e.milliseconds = ai(e.milliseconds)),
                            (e.seconds = ai(e.seconds)),
                            (e.minutes = ai(e.minutes)),
                            (e.hours = ai(e.hours)),
                            (e.months = ai(e.months)),
                            (e.years = ai(e.years)),
                            this
                    );
                }),
                (te.add = function (e, t) {
                    return oi(this, e, t, 1);
                }),
                (te.subtract = function (e, t) {
                    return oi(this, e, t, -1);
                }),
                (te.as = function (e) {
                    if (!this.isValid()) return NaN;
                    var t,
                        i,
                        n = this._milliseconds;
                    if ("month" === (e = P(e)) || "year" === e) return (t = this._days + n / 864e5), (i = this._months + li(t)), "month" === e ? i : i / 12;
                    switch (((t = this._days + Math.round(di(this._months))), e)) {
                        case "week":
                            return t / 7 + n / 6048e5;
                        case "day":
                            return t + n / 864e5;
                        case "hour":
                            return 24 * t + n / 36e5;
                        case "minute":
                            return 1440 * t + n / 6e4;
                        case "second":
                            return 86400 * t + n / 1e3;
                        case "millisecond":
                            return Math.floor(864e5 * t) + n;
                        default:
                            throw new Error("Unknown unit " + e);
                    }
                }),
                (te.asMilliseconds = X),
                (te.asSeconds = V),
                (te.asMinutes = U),
                (te.asHours = J),
                (te.asDays = G),
                (te.asWeeks = oe),
                (te.asMonths = Dt),
                (te.asYears = Et),
                (te.valueOf = function () {
                    return this.isValid() ? this._milliseconds + 864e5 * this._days + (this._months % 12) * 2592e6 + 31536e6 * k(this._months / 12) : NaN;
                }),
                (te._bubble = function () {
                    var e = this._milliseconds,
                        t = this._days,
                        i = this._months,
                        n = this._data;
                    return (
                        (0 <= e && 0 <= t && 0 <= i) || (e <= 0 && t <= 0 && i <= 0) || ((e += 864e5 * ri(di(i) + t)), (i = t = 0)),
                            (n.milliseconds = e % 1e3),
                            (e = _(e / 1e3)),
                            (n.seconds = e % 60),
                            (e = _(e / 60)),
                            (n.minutes = e % 60),
                            (e = _(e / 60)),
                            (n.hours = e % 24),
                            (t += _(e / 24)),
                            (i += e = _(li(t))),
                            (t -= ri(di(e))),
                            (e = _(i / 12)),
                            (i %= 12),
                            (n.days = t),
                            (n.months = i),
                            (n.years = e),
                            this
                    );
                }),
                (te.clone = function () {
                    return Ft(this);
                }),
                (te.get = function (e) {
                    return (e = P(e)), this.isValid() ? this[e + "s"]() : NaN;
                }),
                (te.milliseconds = K),
                (te.seconds = tt),
                (te.minutes = Be),
                (te.hours = Ue),
                (te.days = ee),
                (te.weeks = function () {
                    return _(this.days() / 7);
                }),
                (te.months = Ie),
                (te.years = Te),
                (te.humanize = function (e) {
                    if (!this.isValid()) return this.localeData().invalidDate();
                    var t = this.localeData(),
                        i = fi(this, !e, t);
                    return e && (i = t.pastFuture(+this, i)), t.postformat(i);
                }),
                (te.toISOString = gi),
                (te.toString = gi),
                (te.toJSON = gi),
                (te.locale = Xt),
                (te.localeData = Zt),
                (te.toIsoString = i("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)", gi)),
                (te.lang = Q),
                R("X", 0, 0, "unix"),
                R("x", 0, 0, "valueOf"),
                le("x", ne),
                le("X", /[+-]?\d+(\.\d{1,3})?/),
                he("X", function (e, t, i) {
                    i._d = new Date(1e3 * parseFloat(e, 10));
                }),
                he("x", function (e, t, i) {
                    i._d = new Date(k(e));
                }),
                (f.version = "2.22.2"),
                (e = $t),
                (f.fn = q),
                (f.min = function () {
                    return Mt("isBefore", [].slice.call(arguments, 0));
                }),
                (f.max = function () {
                    return Mt("isAfter", [].slice.call(arguments, 0));
                }),
                (f.now = function () {
                    return Date.now ? Date.now() : +new Date();
                }),
                (f.utc = h),
                (f.unix = function (e) {
                    return $t(1e3 * e);
                }),
                (f.months = function (e, t) {
                    return ni(e, t, "months");
                }),
                (f.isDate = s),
                (f.locale = rt),
                (f.invalid = v),
                (f.duration = Ft),
                (f.isMoment = b),
                (f.weekdays = function (e, t, i) {
                    return si(e, t, i, "weekdays");
                }),
                (f.parseZone = function () {
                    return $t.apply(null, arguments).parseZone();
                }),
                (f.localeData = dt),
                (f.isDuration = Pt),
                (f.monthsShort = function (e, t) {
                    return ni(e, t, "monthsShort");
                }),
                (f.weekdaysMin = function (e, t, i) {
                    return si(e, t, i, "weekdaysMin");
                }),
                (f.defineLocale = lt),
                (f.updateLocale = function (e, t) {
                    var i, n;
                    return (
                        null != t
                            ? ((i = it), null != (n = ot(e)) && (i = n._config), ((t = new M((t = D(i, t)))).parentLocale = nt[e]), (nt[e] = t), rt(e))
                            : null != nt[e] && (null != nt[e].parentLocale ? (nt[e] = nt[e].parentLocale) : null != nt[e] && delete nt[e]),
                            nt[e]
                    );
                }),
                (f.locales = function () {
                    return S(nt);
                }),
                (f.weekdaysShort = function (e, t, i) {
                    return si(e, t, i, "weekdaysShort");
                }),
                (f.normalizeUnits = P),
                (f.relativeTimeRounding = function (e) {
                    return void 0 === e ? hi : "function" == typeof e && ((hi = e), !0);
                }),
                (f.relativeTimeThreshold = function (e, t) {
                    return void 0 !== pi[e] && (void 0 === t ? pi[e] : ((pi[e] = t), "s" === e && (pi.ss = t - 1), !0));
                }),
                (f.calendarFormat = function (e, t) {
                    return (t = e.diff(t, "days", !0)) < -6 ? "sameElse" : t < -1 ? "lastWeek" : t < 0 ? "lastDay" : t < 1 ? "sameDay" : t < 2 ? "nextDay" : t < 7 ? "nextWeek" : "sameElse";
                }),
                (f.prototype = q),
                (f.HTML5_FMT = {
                    DATETIME_LOCAL: "YYYY-MM-DDTHH:mm",
                    DATETIME_LOCAL_SECONDS: "YYYY-MM-DDTHH:mm:ss",
                    DATETIME_LOCAL_MS: "YYYY-MM-DDTHH:mm:ss.SSS",
                    DATE: "YYYY-MM-DD",
                    TIME: "HH:mm",
                    TIME_SECONDS: "HH:mm:ss",
                    TIME_MS: "HH:mm:ss.SSS",
                    WEEK: "YYYY-[W]WW",
                    MONTH: "YYYY-MM",
                }),
                f
        );
    }),
    (function (e) {
        "function" == typeof define && define.amd ? define(["jquery", "moment"], e) : "object" == typeof exports && "undefined" != typeof module ? (module.exports = e(require("jquery"), require("moment"))) : e(jQuery, moment);
    })(function (X, Z) {
        "use strict";
        (X.dateRangePickerLanguages = {
            default: {
                selected: "Selected:",
                day: "Day",
                days: "Days",
                apply: "Close",
                "week-1": "mo",
                "week-2": "tu",
                "week-3": "we",
                "week-4": "th",
                "week-5": "fr",
                "week-6": "sa",
                "week-7": "su",
                "week-number": "W",
                "month-name": ["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"],
                shortcuts: "Shortcuts",
                "custom-values": "Custom Values",
                past: "Past",
                following: "Following",
                previous: "Previous",
                "prev-week": "Week",
                "prev-month": "Month",
                "prev-year": "Year",
                next: "Next",
                "next-week": "Week",
                "next-month": "Month",
                "next-year": "Year",
                "less-than": "Date range should not be more than %d days",
                "more-than": "Date range should not be less than %d days",
                "default-more": "Please select a date range longer than %d days",
                "default-single": "Please select a date",
                "default-less": "Please select a date range less than %d days",
                "default-range": "Please select a date range between %d and %d days",
                "default-default": "Please select a date range",
                time: "Time",
                hour: "Hour",
                minute: "Minute",
            },
            id: {
                selected: "Terpilih:",
                day: "Hari",
                days: "Hari",
                apply: "Tutup",
                "week-1": "sen",
                "week-2": "sel",
                "week-3": "rab",
                "week-4": "kam",
                "week-5": "jum",
                "week-6": "sab",
                "week-7": "min",
                "week-number": "W",
                "month-name": ["januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember"],
                shortcuts: "Pintas",
                "custom-values": "Nilai yang ditentukan",
                past: "Yang Lalu",
                following: "Mengikuti",
                previous: "Sebelumnya",
                "prev-week": "Minggu",
                "prev-month": "Bulan",
                "prev-year": "Tahun",
                next: "Selanjutnya",
                "next-week": "Minggu",
                "next-month": "Bulan",
                "next-year": "Tahun",
                "less-than": "Tanggal harus lebih dari %d hari",
                "more-than": "Tanggal harus kurang dari %d hari",
                "default-more": "Jarak tanggal harus lebih lama dari %d hari",
                "default-single": "Silakan pilih tanggal",
                "default-less": "Jarak rentang tanggal tidak boleh lebih lama dari %d hari",
                "default-range": "Rentang tanggal harus antara %d dan %d hari",
                "default-default": "Silakan pilih rentang tanggal",
                time: "Waktu",
                hour: "Jam",
                minute: "Menit",
            },
            tr: {
                selected: "Seçildi:",
                day: " Gece",
                days: " Gece",
                apply: "Kapat",
                "week-1": "pzt",
                "week-2": "sal",
                "week-3": "çar",
                "week-4": "per",
                "week-5": "cum",
                "week-6": "cts",
                "week-7": "paz",
                "month-name": ["ocak", "şubat", "mart", "nisan", "mayıs", "haziran", "temmuz", "ağustos", "eylül", "ekim", "kasım", "aralık"],
                shortcuts: "Kısayollar",
                past: "Gelecek",
                following: "Gelecek",
                previous: "&nbsp;&nbsp;&nbsp;",
                "prev-week": "Önceki hafta",
                "prev-month": "Önceki ay",
                "prev-year": "Önceki yıl",
                next: "&nbsp;&nbsp;&nbsp;",
                "next-week": "Sonraki hafta",
                "next-month": "Sonraki ay",
                "next-year": "Sonraki yıl",
                "less-than": "Tarih aralığı %d günden çok olmamalıdır",
                "more-than": "Tarih aralığı %d günden az olmamalıdır",
                "default-more": "%d günden ilerde bir tarih seçin",
                "default-single": "Tarih seçin",
                "default-less": "%d günden az bir tarih seçin",
                "default-range": "%d ve %d gün aralığında tarihler seçin",
                "default-default": "Tarih aralığı seçin",
            },
            az: {
                selected: "Seçildi:",
                day: " gün",
                days: " gün",
                apply: "tətbiq",
                "week-1": "1",
                "week-2": "2",
                "week-3": "3",
                "week-4": "4",
                "week-5": "5",
                "week-6": "6",
                "week-7": "7",
                "month-name": ["yanvar", "fevral", "mart", "aprel", "may", "iyun", "iyul", "avqust", "sentyabr", "oktyabr", "noyabr", "dekabr"],
                shortcuts: "Qısayollar",
                past: "Keçmiş",
                following: "Növbəti",
                previous: "&nbsp;&nbsp;&nbsp;",
                "prev-week": "Öncəki həftə",
                "prev-month": "Öncəki ay",
                "prev-year": "Öncəki il",
                next: "&nbsp;&nbsp;&nbsp;",
                "next-week": "Növbəti həftə",
                "next-month": "Növbəti ay",
                "next-year": "Növbəti il",
                "less-than": "Tarix aralığı %d gündən çox olmamalıdır",
                "more-than": "Tarix aralığı %d gündən az olmamalıdır",
                "default-more": "%d gündən çox bir tarix seçin",
                "default-single": "Tarix seçin",
                "default-less": "%d gündən az bir tarix seçin",
                "default-range": "%d və %d gün aralığında tarixlər seçin",
                "default-default": "Tarix aralığı seçin",
            },
            bg: {
                selected: "Избрано:",
                day: "Ден",
                days: "Дни",
                apply: "Затвори",
                "week-1": "пн",
                "week-2": "вт",
                "week-3": "ср",
                "week-4": "чт",
                "week-5": "пт",
                "week-6": "сб",
                "week-7": "нд",
                "week-number": "С",
                "month-name": ["януари", "февруари", "март", "април", "май", "юни", "юли", "август", "септември", "октомври", "ноември", "декември"],
                shortcuts: "Преки пътища",
                "custom-values": "Персонализирани стойности",
                past: "Минал",
                following: "Следващ",
                previous: "Предишен",
                "prev-week": "Седмица",
                "prev-month": "Месец",
                "prev-year": "Година",
                next: "Следващ",
                "next-week": "Седмица",
                "next-month": "Месец",
                "next-year": "Година",
                "less-than": "Периодът от време не трябва да е повече от %d дни",
                "more-than": "Периодът от време не трябва да е по-малко от %d дни",
                "default-more": "Моля изберете период по-дълъг от %d дни",
                "default-single": "Моля изберете дата",
                "default-less": "Моля изберете период по-къс от %d дни",
                "default-range": "Моля изберете период между %d и %d дни",
                "default-default": "Моля изберете период",
                time: "Време",
                hour: "Час",
                minute: "Минута",
            },
            cn: {
                selected: "已选择:",
                day: "天",
                days: "天",
                apply: "确定",
                "week-1": "一",
                "week-2": "二",
                "week-3": "三",
                "week-4": "四",
                "week-5": "五",
                "week-6": "六",
                "week-7": "日",
                "week-number": "周",
                "month-name": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                shortcuts: "快捷选择",
                past: "过去",
                following: "将来",
                previous: "&nbsp;&nbsp;&nbsp;",
                "prev-week": "上周",
                "prev-month": "上个月",
                "prev-year": "去年",
                next: "&nbsp;&nbsp;&nbsp;",
                "next-week": "下周",
                "next-month": "下个月",
                "next-year": "明年",
                "less-than": "所选日期范围不能大于%d天",
                "more-than": "所选日期范围不能小于%d天",
                "default-more": "请选择大于%d天的日期范围",
                "default-less": "请选择小于%d天的日期范围",
                "default-range": "请选择%d天到%d天的日期范围",
                "default-single": "请选择一个日期",
                "default-default": "请选择一个日期范围",
                time: "时间",
                hour: "小时",
                minute: "分钟",
            },
            cz: {
                selected: "Vybráno:",
                day: "Den",
                days: "Dny",
                apply: "Zavřít",
                "week-1": "po",
                "week-2": "út",
                "week-3": "st",
                "week-4": "čt",
                "week-5": "pá",
                "week-6": "so",
                "week-7": "ne",
                "month-name": ["leden", "únor", "březen", "duben", "květen", "červen", "červenec", "srpen", "září", "říjen", "listopad", "prosinec"],
                shortcuts: "Zkratky",
                past: "po",
                following: "následující",
                previous: "předchozí",
                "prev-week": "týden",
                "prev-month": "měsíc",
                "prev-year": "rok",
                next: "další",
                "next-week": "týden",
                "next-month": "měsíc",
                "next-year": "rok",
                "less-than": "Rozsah data by neměl být větší než %d dnů",
                "more-than": "Rozsah data by neměl být menší než %d dnů",
                "default-more": "Prosím zvolte rozsah data větší než %d dnů",
                "default-single": "Prosím zvolte datum",
                "default-less": "Prosím zvolte rozsah data menší než %d dnů",
                "default-range": "Prosím zvolte rozsah data mezi %d a %d dny",
                "default-default": "Prosím zvolte rozsah data",
            },
            de: {
                selected: "Auswahl:",
                day: "Tag",
                days: "Tage",
                apply: "Schließen",
                "week-1": "mo",
                "week-2": "di",
                "week-3": "mi",
                "week-4": "do",
                "week-5": "fr",
                "week-6": "sa",
                "week-7": "so",
                "month-name": ["januar", "februar", "märz", "april", "mai", "juni", "juli", "august", "september", "oktober", "november", "dezember"],
                shortcuts: "Schnellwahl",
                past: "Vorherige",
                following: "Folgende",
                previous: "Vorherige",
                "prev-week": "Woche",
                "prev-month": "Monat",
                "prev-year": "Jahr",
                next: "Nächste",
                "next-week": "Woche",
                "next-month": "Monat",
                "next-year": "Jahr",
                "less-than": "Datumsbereich darf nicht größer sein als %d Tage",
                "more-than": "Datumsbereich darf nicht kleiner sein als %d Tage",
                "default-more": "Bitte mindestens %d Tage auswählen",
                "default-single": "Bitte ein Datum auswählen",
                "default-less": "Bitte weniger als %d Tage auswählen",
                "default-range": "Bitte einen Datumsbereich zwischen %d und %d Tagen auswählen",
                "default-default": "Bitte ein Start- und Enddatum auswählen",
                Time: "Zeit",
                hour: "Stunde",
                minute: "Minute",
            },
            es: {
                selected: "Seleccionado:",
                day: "Día",
                days: "Días",
                apply: "Cerrar",
                "week-1": "lu",
                "week-2": "ma",
                "week-3": "mi",
                "week-4": "ju",
                "week-5": "vi",
                "week-6": "sa",
                "week-7": "do",
                "month-name": ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"],
                shortcuts: "Accesos directos",
                past: "Pasado",
                following: "Siguiente",
                previous: "Anterior",
                "prev-week": "Semana",
                "prev-month": "Mes",
                "prev-year": "Año",
                next: "Siguiente",
                "next-week": "Semana",
                "next-month": "Mes",
                "next-year": "Año",
                "less-than": "El rango no debería ser mayor de %d días",
                "more-than": "El rango no debería ser menor de %d días",
                "default-more": "Por favor selecciona un rango mayor a %d días",
                "default-single": "Por favor selecciona un día",
                "default-less": "Por favor selecciona un rango menor a %d días",
                "default-range": "Por favor selecciona un rango entre %d y %d días",
                "default-default": "Por favor selecciona un rango de fechas.",
            },
            fr: {
                selected: "Sélection:",
                day: "Jour",
                days: "Jours",
                apply: "Fermer",
                "week-1": "lu",
                "week-2": "ma",
                "week-3": "me",
                "week-4": "je",
                "week-5": "ve",
                "week-6": "sa",
                "week-7": "di",
                "month-name": ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"],
                shortcuts: "Raccourcis",
                past: "Passé",
                following: "Suivant",
                previous: "Précédent",
                "prev-week": "Semaine",
                "prev-month": "Mois",
                "prev-year": "Année",
                next: "Suivant",
                "next-week": "Semaine",
                "next-month": "Mois",
                "next-year": "Année",
                "less-than": "L'intervalle ne doit pas être supérieure à %d jours",
                "more-than": "L'intervalle ne doit pas être inférieure à %d jours",
                "default-more": "Merci de choisir une intervalle supérieure à %d jours",
                "default-single": "Merci de choisir une date",
                "default-less": "Merci de choisir une intervalle inférieure %d jours",
                "default-range": "Merci de choisir une intervalle comprise entre %d et %d jours",
                "default-default": "Merci de choisir une date",
            },
            hu: {
                selected: "Kiválasztva:",
                day: "Nap",
                days: "Nap",
                apply: "Ok",
                "week-1": "h",
                "week-2": "k",
                "week-3": "sz",
                "week-4": "cs",
                "week-5": "p",
                "week-6": "sz",
                "week-7": "v",
                "month-name": ["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"],
                shortcuts: "Gyorsválasztó",
                past: "Múlt",
                following: "Következő",
                previous: "Előző",
                "prev-week": "Hét",
                "prev-month": "Hónap",
                "prev-year": "Év",
                next: "Következő",
                "next-week": "Hét",
                "next-month": "Hónap",
                "next-year": "Év",
                "less-than": "A kiválasztás nem lehet több %d napnál",
                "more-than": "A kiválasztás nem lehet több %d napnál",
                "default-more": "Válassz ki egy időszakot ami hosszabb mint %d nap",
                "default-single": "Válassz egy napot",
                "default-less": "Válassz ki egy időszakot ami rövidebb mint %d nap",
                "default-range": "Válassz ki egy %d - %d nap hosszú időszakot",
                "default-default": "Válassz ki egy időszakot",
            },
            it: {
                selected: "Selezionati:",
                day: "Giorno",
                days: "Giorni",
                apply: "Chiudi",
                "week-1": "lu",
                "week-2": "ma",
                "week-3": "me",
                "week-4": "gi",
                "week-5": "ve",
                "week-6": "sa",
                "week-7": "do",
                "month-name": ["gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"],
                shortcuts: "Scorciatoie",
                past: "Scorso",
                following: "Successivo",
                previous: "Precedente",
                "prev-week": "Settimana",
                "prev-month": "Mese",
                "prev-year": "Anno",
                next: "Prossimo",
                "next-week": "Settimana",
                "next-month": "Mese",
                "next-year": "Anno",
                "less-than": "L'intervallo non dev'essere maggiore di %d giorni",
                "more-than": "L'intervallo non dev'essere minore di %d giorni",
                "default-more": "Seleziona un intervallo maggiore di %d giorni",
                "default-single": "Seleziona una data",
                "default-less": "Seleziona un intervallo minore di %d giorni",
                "default-range": "Seleziona un intervallo compreso tra i %d e i %d giorni",
                "default-default": "Seleziona un intervallo di date",
            },
            ko: {
                selected: "기간:",
                day: "일",
                days: "일간",
                apply: "닫기",
                "week-1": "월",
                "week-2": "화",
                "week-3": "수",
                "week-4": "목",
                "week-5": "금",
                "week-6": "토",
                "week-7": "일",
                "week-number": "주",
                "month-name": ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
                shortcuts: "단축키들",
                past: "지난(오늘기준)",
                following: "이후(오늘기준)",
                previous: "이전",
                "prev-week": "1주",
                "prev-month": "1달",
                "prev-year": "1년",
                next: "다음",
                "next-week": "1주",
                "next-month": "1달",
                "next-year": "1년",
                "less-than": "날짜 범위는 %d 일보다 많을 수 없습니다",
                "more-than": "날짜 범위는 %d 일보다 작을 수 없습니다",
                "default-more": "날짜 범위를 %d 일보다 길게 선택해 주세요",
                "default-single": "날짜를 선택해 주세요",
                "default-less": "%d 일보다 작은 날짜를 선택해 주세요",
                "default-range": "%d와 %d 일 사이의 날짜 범위를 선택해 주세요",
                "default-default": "날짜 범위를 선택해 주세요",
                time: "시각",
                hour: "시",
                minute: "분",
            },
            no: {
                selected: "Valgt:",
                day: "Dag",
                days: "Dager",
                apply: "Lukk",
                "week-1": "ma",
                "week-2": "ti",
                "week-3": "on",
                "week-4": "to",
                "week-5": "fr",
                "week-6": "lø",
                "week-7": "sø",
                "month-name": ["januar", "februar", "mars", "april", "mai", "juni", "juli", "august", "september", "oktober", "november", "desember"],
                shortcuts: "Snarveier",
                "custom-values": "Egendefinerte Verdier",
                past: "Over",
                following: "Følger",
                previous: "Forrige",
                "prev-week": "Uke",
                "prev-month": "Måned",
                "prev-year": "År",
                next: "Neste",
                "next-week": "Uke",
                "next-month": "Måned",
                "next-year": "År",
                "less-than": "Datoperioden skal ikkje være lengre enn %d dager",
                "more-than": "Datoperioden skal ikkje være kortere enn %d dager",
                "default-more": "Vennligst velg ein datoperiode lengre enn %d dager",
                "default-single": "Vennligst velg ein dato",
                "default-less": "Vennligst velg ein datoperiode mindre enn %d dager",
                "default-range": "Vennligst velg ein datoperiode mellom %d og %d dager",
                "default-default": "Vennligst velg ein datoperiode",
                time: "Tid",
                hour: "Time",
                minute: "Minutter",
            },
            nl: {
                selected: "Geselecteerd:",
                day: "Dag",
                days: "Dagen",
                apply: "Ok",
                "week-1": "ma",
                "week-2": "di",
                "week-3": "wo",
                "week-4": "do",
                "week-5": "vr",
                "week-6": "za",
                "week-7": "zo",
                "month-name": ["januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december"],
                shortcuts: "Snelkoppelingen",
                "custom-values": "Aangepaste waarden",
                past: "Verleden",
                following: "Komend",
                previous: "Vorige",
                "prev-week": "Week",
                "prev-month": "Maand",
                "prev-year": "Jaar",
                next: "Volgende",
                "next-week": "Week",
                "next-month": "Maand",
                "next-year": "Jaar",
                "less-than": "Interval moet langer dan %d dagen zijn",
                "more-than": "Interval mag niet minder dan %d dagen zijn",
                "default-more": "Selecteer een interval langer dan %dagen",
                "default-single": "Selecteer een datum",
                "default-less": "Selecteer een interval minder dan %d dagen",
                "default-range": "Selecteer een interval tussen %d en %d dagen",
                "default-default": "Selecteer een interval",
                time: "Tijd",
                hour: "Uur",
                minute: "Minuut",
            },
            ru: {
                selected: "Выбрано:",
                day: "День",
                days: "Дней",
                apply: "Применить",
                "week-1": "пн",
                "week-2": "вт",
                "week-3": "ср",
                "week-4": "чт",
                "week-5": "пт",
                "week-6": "сб",
                "week-7": "вс",
                "month-name": ["январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь"],
                shortcuts: "Быстрый выбор",
                "custom-values": "Пользовательские значения",
                past: "Прошедшие",
                following: "Следующие",
                previous: "&nbsp;&nbsp;&nbsp;",
                "prev-week": "Неделя",
                "prev-month": "Месяц",
                "prev-year": "Год",
                next: "&nbsp;&nbsp;&nbsp;",
                "next-week": "Неделя",
                "next-month": "Месяц",
                "next-year": "Год",
                "less-than": "Диапазон не может быть больше %d дней",
                "more-than": "Диапазон не может быть меньше %d дней",
                "default-more": "Пожалуйста выберите диапазон больше %d дней",
                "default-single": "Пожалуйста выберите дату",
                "default-less": "Пожалуйста выберите диапазон меньше %d дней",
                "default-range": "Пожалуйста выберите диапазон между %d и %d днями",
                "default-default": "Пожалуйста выберите диапазон",
                time: "Время",
                hour: "Часы",
                minute: "Минуты",
            },
            uk: {
                selected: "Вибрано:",
                day: "День",
                days: "Днів",
                apply: "Застосувати",
                "week-1": "пн",
                "week-2": "вт",
                "week-3": "ср",
                "week-4": "чт",
                "week-5": "пт",
                "week-6": "сб",
                "week-7": "нд",
                "month-name": ["січень", "лютий", "березень", "квітень", "травень", "червень", "липень", "серпень", "вересень", "жовтень", "листопад", "грудень"],
                shortcuts: "Швидкий вибір",
                "custom-values": "Значення користувача",
                past: "Минулі",
                following: "Наступні",
                previous: "&nbsp;&nbsp;&nbsp;",
                "prev-week": "Тиждень",
                "prev-month": "Місяць",
                "prev-year": "Рік",
                next: "&nbsp;&nbsp;&nbsp;",
                "next-week": "Тиждень",
                "next-month": "Місяць",
                "next-year": "Рік",
                "less-than": "Діапазон не може бути більш ніж %d днів",
                "more-than": "Діапазон не може бути меньш ніж %d днів",
                "default-more": "Будь ласка виберіть діапазон більше %d днів",
                "default-single": "Будь ласка виберіть дату",
                "default-less": "Будь ласка виберіть діапазон менше %d днів",
                "default-range": "Будь ласка виберіть діапазон між %d та %d днями",
                "default-default": "Будь ласка виберіть діапазон",
                time: "Час",
                hour: "Години",
                minute: "Хвилини",
            },
            pl: {
                selected: "Wybrany:",
                day: "Dzień",
                days: "Dni",
                apply: "Zamknij",
                "week-1": "pon",
                "week-2": "wt",
                "week-3": "śr",
                "week-4": "czw",
                "week-5": "pt",
                "week-6": "so",
                "week-7": "nd",
                "month-name": ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec", "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"],
                shortcuts: "Skróty",
                "custom-values": "Niestandardowe wartości",
                past: "Przeszłe",
                following: "Następne",
                previous: "Poprzednie",
                "prev-week": "tydzień",
                "prev-month": "miesiąc",
                "prev-year": "rok",
                next: "Następny",
                "next-week": "tydzień",
                "next-month": "miesiąc",
                "next-year": "rok",
                "less-than": "Okres nie powinien być dłuższy niż %d dni",
                "more-than": "Okres nie powinien być krótszy niż  %d ni",
                "default-more": "Wybierz okres dłuższy niż %d dni",
                "default-single": "Wybierz datę",
                "default-less": "Wybierz okres krótszy niż %d dni",
                "default-range": "Wybierz okres trwający od %d do %d dni",
                "default-default": "Wybierz okres",
                time: "Czas",
                hour: "Godzina",
                minute: "Minuta",
            },
            se: {
                selected: "Vald:",
                day: "dag",
                days: "dagar",
                apply: "godkänn",
                "week-1": "ma",
                "week-2": "ti",
                "week-3": "on",
                "week-4": "to",
                "week-5": "fr",
                "week-6": "lö",
                "week-7": "sö",
                "month-name": ["januari", "februari", "mars", "april", "maj", "juni", "juli", "augusti", "september", "oktober", "november", "december"],
                shortcuts: "genvägar",
                "custom-values": "Anpassade värden",
                past: "över",
                following: "följande",
                previous: "förra",
                "prev-week": "vecka",
                "prev-month": "månad",
                "prev-year": "år",
                next: "nästa",
                "next-week": "vecka",
                "next-month": "måned",
                "next-year": "år",
                "less-than": "Datumintervall bör inte vara mindre än %d dagar",
                "more-than": "Datumintervall bör inte vara mer än %d dagar",
                "default-more": "Välj ett datumintervall längre än %d dagar",
                "default-single": "Välj ett datum",
                "default-less": "Välj ett datumintervall mindre än %d dagar",
                "default-range": "Välj ett datumintervall mellan %d och %d dagar",
                "default-default": "Välj ett datumintervall",
                time: "tid",
                hour: "timme",
                minute: "minut",
            },
            pt: {
                selected: "Selecionado:",
                day: "Dia",
                days: "Dias",
                apply: "Fechar",
                "week-1": "seg",
                "week-2": "ter",
                "week-3": "qua",
                "week-4": "qui",
                "week-5": "sex",
                "week-6": "sab",
                "week-7": "dom",
                "week-number": "N",
                "month-name": ["janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"],
                shortcuts: "Atalhos",
                "custom-values": "Valores Personalizados",
                past: "Passado",
                following: "Seguinte",
                previous: "Anterior",
                "prev-week": "Semana",
                "prev-month": "Mês",
                "prev-year": "Ano",
                next: "Próximo",
                "next-week": "Próxima Semana",
                "next-month": "Próximo Mês",
                "next-year": "Próximo Ano",
                "less-than": "O período selecionado não deve ser maior que %d dias",
                "more-than": "O período selecionado não deve ser menor que %d dias",
                "default-more": "Selecione um período superior a %d dias",
                "default-single": "Selecione uma data",
                "default-less": "Selecione um período inferior a %d dias",
                "default-range": "Selecione um período de %d a %d dias",
                "default-default": "Selecione um período",
                time: "Tempo",
                hour: "Hora",
                minute: "Minuto",
            },
            tc: {
                selected: "已選擇:",
                day: "天",
                days: "天",
                apply: "確定",
                "week-1": "一",
                "week-2": "二",
                "week-3": "三",
                "week-4": "四",
                "week-5": "五",
                "week-6": "六",
                "week-7": "日",
                "week-number": "周",
                "month-name": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                shortcuts: "快速選擇",
                past: "過去",
                following: "將來",
                previous: "&nbsp;&nbsp;&nbsp;",
                "prev-week": "上週",
                "prev-month": "上個月",
                "prev-year": "去年",
                next: "&nbsp;&nbsp;&nbsp;",
                "next-week": "下周",
                "next-month": "下個月",
                "next-year": "明年",
                "less-than": "所選日期範圍不能大於%d天",
                "more-than": "所選日期範圍不能小於%d天",
                "default-more": "請選擇大於%d天的日期範圍",
                "default-less": "請選擇小於%d天的日期範圍",
                "default-range": "請選擇%d天到%d天的日期範圍",
                "default-single": "請選擇一個日期",
                "default-default": "請選擇一個日期範圍",
                time: "日期",
                hour: "小時",
                minute: "分鐘",
            },
            ja: {
                selected: "選択しました:",
                day: "日",
                days: "日々",
                apply: "閉じる",
                "week-1": "月",
                "week-2": "火",
                "week-3": "水",
                "week-4": "木",
                "week-5": "金",
                "week-6": "土",
                "week-7": "日",
                "month-name": ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
                shortcuts: "クイック選択",
                past: "過去",
                following: "将来",
                previous: "&nbsp;&nbsp;&nbsp;",
                "prev-week": "先週、",
                "prev-month": "先月",
                "prev-year": "昨年",
                next: "&nbsp;&nbsp;&nbsp;",
                "next-week": "来週",
                "next-month": "来月",
                "next-year": "来年",
                "less-than": "日付の範囲は ％d 日以上にすべきではありません",
                "more-than": "日付の範囲は ％d 日を下回ってはいけません",
                "default-more": "％d 日よりも長い期間を選択してください",
                "default-less": "％d 日未満の期間を選択してください",
                "default-range": "％d と％ d日の間の日付範囲を選択してください",
                "default-single": "日付を選択してください",
                "default-default": "日付範囲を選択してください",
                time: "時間",
                hour: "時間",
                minute: "分",
            },
            da: {
                selected: "Valgt:",
                day: "Dag",
                days: "Dage",
                apply: "Luk",
                "week-1": "ma",
                "week-2": "ti",
                "week-3": "on",
                "week-4": "to",
                "week-5": "fr",
                "week-6": "lö",
                "week-7": "sö",
                "month-name": ["januar", "februar", "marts", "april", "maj", "juni", "juli", "august", "september", "oktober", "november", "december"],
                shortcuts: "genveje",
                "custom-values": "Brugerdefinerede værdier",
                past: "Forbi",
                following: "Følgende",
                previous: "Forrige",
                "prev-week": "uge",
                "prev-month": "månad",
                "prev-year": "år",
                next: "Næste",
                "next-week": "Næste uge",
                "next-month": "Næste måned",
                "next-year": "Næste år",
                "less-than": "Dato interval bør ikke være med end %d dage",
                "more-than": "Dato interval bør ikke være mindre end %d dage",
                "default-more": "Vælg datointerval længere end %d dage",
                "default-single": "Vælg dato",
                "default-less": "Vælg datointerval mindre end %d dage",
                "default-range": "Vælg datointerval mellem %d og %d dage",
                "default-default": "Vælg datointerval",
                time: "tid",
                hour: "time",
                minute: "minut",
            },
            fi: {
                selected: "Valittu:",
                day: "Päivä",
                days: "Päivää",
                apply: "Sulje",
                "week-1": "ma",
                "week-2": "ti",
                "week-3": "ke",
                "week-4": "to",
                "week-5": "pe",
                "week-6": "la",
                "week-7": "su",
                "week-number": "V",
                "month-name": ["tammikuu", "helmikuu", "maaliskuu", "huhtikuu", "toukokuu", "kesäkuu", "heinäkuu", "elokuu", "syyskuu", "lokakuu", "marraskuu", "joulukuu"],
                shortcuts: "Pikavalinnat",
                "custom-values": "Mukautetut Arvot",
                past: "Menneet",
                following: "Tulevat",
                previous: "Edellinen",
                "prev-week": "Viikko",
                "prev-month": "Kuukausi",
                "prev-year": "Vuosi",
                next: "Seuraava",
                "next-week": "Viikko",
                "next-month": "Kuukausi",
                "next-year": "Vuosi",
                "less-than": "Aikajakson tulisi olla vähemmän kuin %d päivää",
                "more-than": "Aikajakson ei tulisi olla vähempää kuin %d päivää",
                "default-more": "Valitse pidempi aikajakso kuin %d päivää",
                "default-single": "Valitse päivä",
                "default-less": "Valitse lyhyempi aikajakso kuin %d päivää",
                "default-range": "Valitse aikajakso %d ja %d päivän väliltä",
                "default-default": "Valitse aikajakso",
                time: "Aika",
                hour: "Tunti",
                minute: "Minuutti",
            },
            cat: {
                selected: "Seleccionats:",
                day: "Dia",
                days: "Dies",
                apply: "Tanca",
                "week-1": "Dl",
                "week-2": "Dm",
                "week-3": "Dc",
                "week-4": "Dj",
                "week-5": "Dv",
                "week-6": "Ds",
                "week-7": "Dg",
                "week-number": "S",
                "month-name": ["gener", "febrer", "març", "abril", "maig", "juny", "juliol", "agost", "setembre", "octubre", "novembre", "desembre"],
                shortcuts: "Dreçeres",
                "custom-values": "Valors personalitzats",
                past: "Passat",
                following: "Futur",
                previous: "Anterior",
                "prev-week": "Setmana",
                "prev-month": "Mes",
                "prev-year": "Any",
                next: "Següent",
                "next-week": "Setmana",
                "next-month": "Mes",
                "next-year": "Any",
                "less-than": "El període no hauria de ser de més de %d dies",
                "more-than": "El període no hauria de ser de menys de %d dies",
                "default-more": "Perfavor selecciona un període més gran de %d dies",
                "default-single": "Perfavor selecciona una data",
                "default-less": "Perfavor selecciona un període de menys de %d dies",
                "default-range": "Perfavor selecciona un període d'entre %d i %d dies",
                "default-default": "Perfavor selecciona un període",
                time: "Temps",
                hour: "Hora",
                minute: "Minut",
            },
        }),
            (X.fn.dateRangePicker = function (p) {
                (p = p || {}),
                    ((p = X.extend(
                        !0,
                        {
                            autoClose: !1,
                            format: "YYYY-MM-DD",
                            separator: " to ",
                            language: "auto",
                            startOfWeek: "sunday",
                            getValue: function () {
                                return X(this).val();
                            },
                            setValue: function (e) {
                                X(this).attr("readonly") || X(this).is(":disabled") || e == X(this).val() || X(this).val(e);
                            },
                            startDate: !1,
                            endDate: !1,
                            time: { enabled: !1 },
                            minDays: 0,
                            maxDays: 0,
                            showShortcuts: !1,
                            shortcuts: {},
                            customShortcuts: [],
                            inline: !1,
                            container: "body",
                            alwaysOpen: !1,
                            singleDate: !1,
                            lookBehind: !1,
                            batchMode: !1,
                            duration: 200,
                            stickyMonths: !1,
                            dayDivAttrs: [],
                            dayTdAttrs: [],
                            selectForward: !1,
                            selectBackward: !1,
                            applyBtnClass: "",
                            singleMonth: "auto",
                            hoveringTooltip: function (e, t, i) {
                                return 1 < e ? e + " " + V("days") : "";
                            },
                            showTopbar: !0,
                            swapTime: !1,
                            showWeekNumbers: !1,
                            getWeekNumber: function (e) {
                                return Z(e).format("w");
                            },
                            customOpenAnimation: null,
                            customCloseAnimation: null,
                            customArrowPrevSymbol: null,
                            customArrowNextSymbol: null,
                            monthSelect: !1,
                            yearSelect: !1,
                        },
                        p
                    )).start = !1),
                    (p.end = !1),
                    (p.startWeek = !1),
                    (p.isTouchDevice = "ontouchstart" in window || navigator.msMaxTouchPoints),
                p.isTouchDevice && (p.hoveringTooltip = !1),
                "auto" == p.singleMonth && (p.singleMonth = X(window).width() < 480),
                p.singleMonth && (p.stickyMonths = !1),
                p.showTopbar || (p.autoClose = !0),
                p.startDate && "string" == typeof p.startDate && (p.startDate = Z(p.startDate, p.format).toDate()),
                p.endDate && "string" == typeof p.endDate && (p.endDate = Z(p.endDate, p.format).toDate()),
                p.yearSelect &&
                "boolean" == typeof p.yearSelect &&
                (p.yearSelect = function (e) {
                    return [e - 5, e + 5];
                });
                var l,
                    e,
                    s = (function () {
                        if ("auto" != p.language) return p.language && p.language in X.dateRangePickerLanguages ? X.dateRangePickerLanguages[p.language] : X.dateRangePickerLanguages.default;
                        var e = navigator.language || navigator.browserLanguage;
                        return e && (e = e.toLowerCase()) in X.dateRangePickerLanguages ? X.dateRangePickerLanguages[e] : X.dateRangePickerLanguages.default;
                    })(),
                    n = !1,
                    a = this,
                    o = X(a).get(0);
                return (
                    X(this)
                        .off(".datepicker")
                        .on("click.datepicker", function (e) {
                            l.is(":visible") || t(p.duration);
                        })
                        .on("change.datepicker", function (e) {
                            i();
                        })
                        .on("keyup.datepicker", function () {
                            try {
                                clearTimeout(e);
                            } catch (e) {}
                            e = setTimeout(function () {
                                i();
                            }, 2e3);
                        }),
                        function () {
                            var e,
                                t,
                                i = this;
                            X(this).data("date-picker-opened")
                                ? L()
                                : (X(this).data("date-picker-opened", !0),
                                    (l = (function () {
                                        var e = '<div class="date-picker-wrapper';
                                        p.extraClass && (e += " " + p.extraClass + " "),
                                        p.singleDate && (e += " single-date "),
                                        p.showShortcuts || (e += " no-shortcuts "),
                                        p.showTopbar || (e += " no-topbar "),
                                        p.customTopBar && (e += " custom-topbar "),
                                            (e += '">'),
                                        p.showTopbar &&
                                        ((e += '<div class="drp_top-bar">'),
                                            p.customTopBar
                                                ? ("function" == typeof p.customTopBar && (p.customTopBar = p.customTopBar()), (e += '<div class="custom-top">' + p.customTopBar + "</div>"))
                                                : ((e += '<div class="normal-top"><span class="selection-top">' + V("selected") + ' </span> <b class="start-day">...</b>'),
                                                p.singleDate ||
                                                (e += ' <span class="separator-day">' + p.separator + '</span> <b class="end-day">...</b> <i class="selected-days">(<span class="selected-days-num">3</span> ' + V("days") + ")</i>"),
                                                    (e += "</div>"),
                                                    (e += '<div class="error-top">error</div><div class="default-top">default</div>')),
                                            (e += '<input type="button" class="apply-btn disabled" value="' + V("apply") + '" />'),
                                            (e += "</div>"));
                                        var t = p.showWeekNumbers ? 6 : 5,
                                            i = "&lt;";
                                        p.customArrowPrevSymbol && (i = p.customArrowPrevSymbol);
                                        var n = "&gt;";
                                        if (
                                            (p.customArrowNextSymbol && (n = p.customArrowNextSymbol),
                                                (e +=
                                                    '<div class="month-wrapper">   <table class="month1" cellspacing="0" border="0" cellpadding="0">       <thead>           <tr class="caption">               <th>                   <span class="prev">' +
                                                    i +
                                                    '                   </span>               </th>               <th colspan="' +
                                                    t +
                                                    '" class="month-name">               </th>               <th>' +
                                                    (p.singleDate || !p.stickyMonths ? '<span class="next">' + n + "</span>" : "") +
                                                    '               </th>           </tr>           <tr class="week-name">' +
                                                    R() +
                                                    "       </thead>       <tbody></tbody>   </table>"),
                                            p.singleMonth ||
                                            (e +=
                                                '<div class="gap">' +
                                                (function () {
                                                    for (var e = ['<div class="gap-top-mask"></div><div class="gap-bottom-mask"></div><div class="gap-lines">'], t = 0; t < 20; t++)
                                                        e.push('<div class="gap-line"><div class="gap-1"></div><div class="gap-2"></div><div class="gap-3"></div></div>');
                                                    return e.push("</div>"), e.join("");
                                                })() +
                                                '</div><table class="month2" cellspacing="0" border="0" cellpadding="0">   <thead>   <tr class="caption">       <th>' +
                                                (p.stickyMonths ? "" : '<span class="prev">' + i + "</span>") +
                                                '       </th>       <th colspan="' +
                                                t +
                                                '" class="month-name">       </th>       <th>           <span class="next">' +
                                                n +
                                                '</span>       </th>   </tr>   <tr class="week-name">' +
                                                R() +
                                                "   </thead>   <tbody></tbody></table>"),
                                                (e += '<div class="dp-clearfix"></div><div class="time"><div class="time1"></div>'),
                                            p.singleDate || (e += '<div class="time2"></div>'),
                                                (e += '</div><div class="dp-clearfix"></div></div>'),
                                                (e += '<div class="footer">'),
                                                p.showShortcuts)
                                        ) {
                                            e += '<div class="shortcuts"><b>' + V("shortcuts") + "</b>";
                                            var s,
                                                a = p.shortcuts;
                                            if (a) {
                                                if (a["prev-days"] && 0 < a["prev-days"].length) {
                                                    e += '&nbsp;<span class="prev-days">' + V("past");
                                                    for (var o = 0; o < a["prev-days"].length; o++)
                                                        (s = a["prev-days"][o]), (s += 1 < a["prev-days"][o] ? V("days") : V("day")), (e += ' <a href="javascript:;" shortcut="day,-' + a["prev-days"][o] + '">' + s + "</a>");
                                                    e += "</span>";
                                                }
                                                if (a["next-days"] && 0 < a["next-days"].length) {
                                                    e += '&nbsp;<span class="next-days">' + V("following");
                                                    for (o = 0; o < a["next-days"].length; o++)
                                                        (s = a["next-days"][o]), (s += 1 < a["next-days"][o] ? V("days") : V("day")), (e += ' <a href="javascript:;" shortcut="day,' + a["next-days"][o] + '">' + s + "</a>");
                                                    e += "</span>";
                                                }
                                                if (a.prev && 0 < a.prev.length) {
                                                    e += '&nbsp;<span class="prev-buttons">' + V("previous");
                                                    for (o = 0; o < a.prev.length; o++) (s = V("prev-" + a.prev[o])), (e += ' <a href="javascript:;" shortcut="prev,' + a.prev[o] + '">' + s + "</a>");
                                                    e += "</span>";
                                                }
                                                if (a.next && 0 < a.next.length) {
                                                    e += '&nbsp;<span class="next-buttons">' + V("next");
                                                    for (o = 0; o < a.next.length; o++) (s = V("next-" + a.next[o])), (e += ' <a href="javascript:;" shortcut="next,' + a.next[o] + '">' + s + "</a>");
                                                    e += "</span>";
                                                }
                                            }
                                            if (p.customShortcuts) for (o = 0; o < p.customShortcuts.length; o++) e += '&nbsp;<span class="custom-shortcut"><a href="javascript:;" shortcut="custom">' + p.customShortcuts[o].name + "</a></span>";
                                            e += "</div>";
                                        }
                                        if (p.showCustomValues && ((e += '<div class="customValues"><b>' + (p.customValueLabel || V("custom-values")) + "</b>"), p.customValues))
                                            for (o = 0; o < p.customValues.length; o++) {
                                                var r = p.customValues[o];
                                                e += '&nbsp;<span class="custom-value"><a href="javascript:;" custom="' + r.value + '">' + r.name + "</a></span>";
                                            }
                                        return X((e += "</div></div>"));
                                    })().hide()).append('<div class="date-range-length-tip"></div>'),
                                    X(p.container).append(l),
                                    p.inline ? l.addClass("inline-wrapper") : r(),
                                p.alwaysOpen && l.find(".apply-btn").hide(),
                                    G((e = U())),
                                p.time.enabled &&
                                ((p.startDate && p.endDate) || (p.start && p.end)
                                    ? (I(Z(p.start || p.startDate).toDate(), "time1"), I(Z(p.end || p.endDate).toDate(), "time2"))
                                    : ((t = p.defaultEndTime || e), I(e, "time1"), I(t, "time2"))),
                                    (t = ""),
                                    (t = p.singleDate ? V("default-single") : p.minDays && p.maxDays ? V("default-range") : p.minDays ? V("default-more") : p.maxDays ? V("default-less") : V("default-default")),
                                    l.find(".default-top").html(t.replace(/\%d/, p.minDays).replace(/\%d/, p.maxDays)),
                                    p.singleMonth ? l.addClass("single-month") : l.addClass("two-months"),
                                    setTimeout(function () {
                                        c(), (n = !0);
                                    }, 0),
                                    l.click(function (e) {
                                        e.stopPropagation();
                                    }),
                                    X(document).on("click.datepicker", q),
                                    l.find(".next").click(function () {
                                        var e, t;
                                        p.stickyMonths
                                            ? ((e = j(p.month1)), F((t = j(p.month2))) || (!p.singleDate && 0 <= N(e, t)) || (D(e, "month1"), D(t, "month2"), E()))
                                            : ((e = j(
                                                (e = (t = X((e = this))
                                                    .parents("table")
                                                    .hasClass("month2"))
                                                    ? p.month2
                                                    : p.month1)
                                            )),
                                            (!p.singleMonth && !p.singleDate && !t && 0 <= N(e, p.month2)) || F(e) || (D(e, t ? "month2" : "month1"), z()));
                                    }),
                                    l.find(".prev").click(function () {
                                        var e, t;
                                        p.stickyMonths
                                            ? ((e = H(p.month1)), (t = H(p.month2)), F(e) || (!p.singleDate && N(t, e) <= 0) || (D(t, "month2"), D(e, "month1"), E()))
                                            : ((t = H(
                                                (t = (e = X((t = this))
                                                    .parents("table")
                                                    .hasClass("month2"))
                                                    ? p.month2
                                                    : p.month1)
                                            )),
                                            (e && N(t, p.month1) <= 0) || F(t) || (D(t, e ? "month2" : "month1"), z()));
                                    }),
                                    l
                                        .attr("unselectable", "on")
                                        .css("user-select", "none")
                                        .on("selectstart", function (e) {
                                            return e.preventDefault(), !1;
                                        }),
                                    l.find(".apply-btn").click(function () {
                                        L();
                                        var e = A(new Date(p.start)) + p.separator + A(new Date(p.end));
                                        X(i).trigger("datepicker-apply", { value: e, date1: new Date(p.start), date2: new Date(p.end) });
                                    }),
                                    l.find("[custom]").click(function () {
                                        var e = X(this).attr("custom");
                                        (p.start = !1), (p.end = !1), l.find(".day.checked").removeClass("checked"), p.setValue.call(o, e), x(), C(!0), E(), p.autoClose && L();
                                    }),
                                    l.find("[shortcut]").click(function () {
                                        var e = X(this).attr("shortcut"),
                                            t = new Date(),
                                            i = !1;
                                        if (-1 != e.indexOf("day"))
                                            var n = parseInt(e.split(",", 2)[1], 10),
                                                i = new Date(new Date().getTime() + 864e5 * n),
                                                t = new Date(t.getTime() + 864e5 * (0 < n ? 1 : -1));
                                        else if (-1 != e.indexOf("week")) {
                                            var s,
                                                a = 1 == (s = -1 != e.indexOf("prev,") ? -1 : 1) ? ("monday" == p.startOfWeek ? 1 : 0) : "monday" == p.startOfWeek ? 0 : 6;
                                            for (t = new Date(t.getTime() - 864e5); t.getDay() != a; ) t = new Date(t.getTime() + 864e5 * s);
                                            i = new Date(t.getTime() + 864e5 * s * 6);
                                        } else if (-1 != e.indexOf("month")) (i = (1 == (s = -1 != e.indexOf("prev,") ? -1 : 1) ? j : H)(t)).setDate(1), (t = j(i)).setDate(1), (t = new Date(t.getTime() - 864e5));
                                        else if (-1 != e.indexOf("year"))
                                            (s = -1 != e.indexOf("prev,") ? -1 : 1), (i = new Date()).setFullYear(t.getFullYear() + s), i.setMonth(0), i.setDate(1), t.setFullYear(t.getFullYear() + s), t.setMonth(11), t.setDate(31);
                                        else if ("custom" == e) {
                                            var o = X(this).html();
                                            if (p.customShortcuts && 0 < p.customShortcuts.length)
                                                for (var r = 0; r < p.customShortcuts.length; r++) {
                                                    var l = p.customShortcuts[r];
                                                    if (l.name == o) {
                                                        var d = [];
                                                        (d = l.dates.call()) && 2 == d.length && ((i = d[0]), (t = d[1])), d && 1 == d.length && (D((d = d[0]), "month1"), D(j(d), "month2"), z());
                                                        break;
                                                    }
                                                }
                                        }
                                        i && t && (T(i, t), x());
                                    }),
                                    l.find(".time1 input[type=range]").on("change touchmove", function (e) {
                                        e = e.target;
                                        f(
                                            "time1",
                                            "hour" == e.name
                                                ? X(e)
                                                    .val()
                                                    .replace(/^(\d{1})$/, "0$1")
                                                : void 0,
                                            "minute" == e.name
                                                ? X(e)
                                                    .val()
                                                    .replace(/^(\d{1})$/, "0$1")
                                                : void 0
                                        );
                                    }),
                                    l.find(".time2 input[type=range]").on("change touchmove", function (e) {
                                        e = e.target;
                                        f(
                                            "time2",
                                            "hour" == e.name
                                                ? X(e)
                                                    .val()
                                                    .replace(/^(\d{1})$/, "0$1")
                                                : void 0,
                                            "minute" == e.name
                                                ? X(e)
                                                    .val()
                                                    .replace(/^(\d{1})$/, "0$1")
                                                : void 0
                                        );
                                    }));
                        }.call(this),
                    p.alwaysOpen && t(0),
                        X(this).data("dateRangePicker", {
                            setStart: function (e) {
                                return "string" == typeof e && (e = Z(e, p.format).toDate()), (p.end = !1), $(e), this;
                            },
                            setEnd: function (e, t) {
                                var i = new Date();
                                return i.setTime(p.start), "string" == typeof e && (e = Z(e, p.format).toDate()), T(i, e, t), this;
                            },
                            setDateRange: function (e, t, i) {
                                "string" == typeof e && "string" == typeof t && ((e = Z(e, p.format).toDate()), (t = Z(t, p.format).toDate())), T(e, t, i);
                            },
                            clear: function () {
                                (p.start = !1),
                                    (p.end = !1),
                                    l.find(".day.checked").removeClass("checked"),
                                    l.find(".day.last-date-selected").removeClass("last-date-selected"),
                                    l.find(".day.first-date-selected").removeClass("first-date-selected"),
                                    p.setValue.call(o, ""),
                                    x(),
                                    C(),
                                    E();
                            },
                            close: L,
                            open: t,
                            redraw: W,
                            getDatePicker: function () {
                                return l;
                            },
                            resetMonthsView: G,
                            destroy: function () {
                                X(a).off(".datepicker"), X(a).data("dateRangePicker", ""), X(a).data("date-picker-opened", null), l.remove(), X(window).off("resize.datepicker", r), X(document).off("click.datepicker", q);
                            },
                        }),
                        X(window).on("resize.datepicker", r),
                        this
                );
                function r() {
                    var e, t, i;
                    p.inline ||
                    ((e = X(a).offset()),
                        "relative" == X(p.container).css("position")
                            ? ((t = X(p.container).offset()), (i = Math.max(0, e.left + l.outerWidth() - X("body").width() + 16)), l.css({ top: e.top - t.top + X(a).outerHeight() + 4, left: e.left - t.left - i }))
                            : e.left < 460
                                ? l.css({ top: e.top + X(a).outerHeight() + parseInt(X("body").css("border-top") || 0, 10), left: e.left })
                                : l.css({ top: e.top + X(a).outerHeight() + parseInt(X("body").css("border-top") || 0, 10), left: e.left + X(a).width() - l.width() - 16 }));
                }
                function t(e) {
                    W(),
                        i(),
                        p.customOpenAnimation
                            ? p.customOpenAnimation.call(l.get(0), function () {
                                X(a).trigger("datepicker-opened", { relatedTarget: l });
                            })
                            : l.slideDown(e, function () {
                                X(a).trigger("datepicker-opened", { relatedTarget: l });
                            }),
                        X(a).trigger("datepicker-open", { relatedTarget: l }),
                        z(),
                        c(),
                        r();
                }
                function i() {
                    var e = p.getValue.call(o),
                        t = e ? e.split(p.separator) : "";
                    t &&
                    ((1 == t.length && p.singleDate) || 2 <= t.length) &&
                    ((e = p.format).match(/Do/) && ((e = e.replace(/Do/, "D")), (t[0] = t[0].replace(/(\d+)(th|nd|st)/, "$1")), 2 <= t.length && (t[1] = t[1].replace(/(\d+)(th|nd|st)/, "$1"))),
                        (n = !1),
                        2 <= t.length ? T(d(t[0], e, Z.locale(p.language)), d(t[1], e, Z.locale(p.language))) : 1 == t.length && p.singleDate && $(d(t[0], e, Z.locale(p.language))),
                        (n = !0));
                }
                function d(e, t, i) {
                    return (Z(e, t, i).isValid() ? Z(e, t, i) : Z()).toDate();
                }
                function c() {
                    var e = (e = l.find(".gap").css("margin-left")) && parseInt(e),
                        t = l.find(".month1").width(),
                        i = l.find(".gap").width() + (e ? 2 * e : 0),
                        e = l.find(".month2").width();
                    l.find(".month-wrapper").width(t + i + e);
                }
                function u(e, t) {
                    l.find("." + e + " input[type=range].hour-range").val(Z(t).hours()), l.find("." + e + " input[type=range].minute-range").val(Z(t).minutes()), f(e, Z(t).format("HH"), Z(t).format("mm"));
                }
                function h(e, t) {
                    p[e] = parseInt(
                        Z(parseInt(t))
                            .startOf("day")
                            .add(Z(p[e + "Time"]).format("HH"), "h")
                            .add(Z(p[e + "Time"]).format("mm"), "m")
                            .valueOf()
                    );
                }
                function f(e, s, a) {
                    switch ((s && l.find("." + e + " .hour-val").text(s), a && l.find("." + e + " .minute-val").text(a), e)) {
                        case "time1":
                            p.start && t("start", Z(p.start)), t("startTime", Z(p.startTime || Z().valueOf()));
                            break;
                        case "time2":
                            p.end && t("end", Z(p.end)), t("endTime", Z(p.endTime || Z().valueOf()));
                    }
                    function t(e, t) {
                        var i = t.format("HH"),
                            n = t.format("mm");
                        p[e] = t
                            .startOf("day")
                            .add(s || i, "h")
                            .add(a || n, "m")
                            .valueOf();
                    }
                    x(), C(), E();
                }
                function m(e) {
                    var t = e;
                    return (
                        "week-range" === p.batchMode
                            ? (t = ("monday" === p.startOfWeek ? Z(parseInt(e)).startOf("isoweek") : Z(parseInt(e)).startOf("week")).valueOf())
                            : "month-range" === p.batchMode && (t = Z(parseInt(e)).startOf("month").valueOf()),
                            t
                    );
                }
                function v(e) {
                    var t = e;
                    return (
                        "week-range" === p.batchMode
                            ? (t = ("monday" === p.startOfWeek ? Z(parseInt(e)).endOf("isoweek") : Z(parseInt(e)).endOf("week")).valueOf())
                            : "month-range" === p.batchMode && (t = Z(parseInt(e)).endOf("month").valueOf()),
                            t
                    );
                }
                function g(e) {
                    if (((e = parseInt(e, 10)), p.startDate && Y(e, p.startDate) < 0)) return !1;
                    if (p.endDate && 0 < Y(e, p.endDate)) return !1;
                    if (p.start && !p.end && !p.singleDate) {
                        if (0 < p.maxDays && S(e, p.start) > p.maxDays) return !1;
                        if (0 < p.minDays && S(e, p.start) < p.minDays) return !1;
                        if (p.selectForward && e < p.start) return !1;
                        if (p.selectBackward && e > p.start) return !1;
                        if (p.beforeShowDay && "function" == typeof p.beforeShowDay) {
                            for (var t = !0, i = e; 1 < S(i, p.start); ) {
                                if (!p.beforeShowDay(new Date(i))[0]) {
                                    t = !1;
                                    break;
                                }
                                if (Math.abs(i - p.start) < 864e5) break;
                                i > p.start && (i -= 864e5), i < p.start && (i += 864e5);
                            }
                            if (!t) return !1;
                        }
                    }
                    return !0;
                }
                function w() {
                    return (
                        l.find(".day.invalid.tmp").removeClass("tmp invalid").addClass("valid"),
                        p.start &&
                        !p.end &&
                        l.find(".day.toMonth.valid").each(function () {
                            g(parseInt(X(this).attr("time"), 10)) ? X(this).addClass("valid tmp").removeClass("invalid") : X(this).addClass("invalid tmp").removeClass("valid");
                        }),
                            1
                    );
                }
                function y(e) {
                    var t,
                        i,
                        n,
                        s,
                        a,
                        o = parseInt(e.attr("time")),
                        r = "";
                    e.hasClass("has-tooltip") && e.attr("data-tooltip")
                        ? (r = '<span class="tooltip-content">' + e.attr("data-tooltip") + "</span>")
                        : e.hasClass("invalid") ||
                        (p.singleDate
                            ? (l.find(".day.hovering").removeClass("hovering"), e.addClass("hovering"))
                            : (l.find(".day").each(function () {
                                var e = parseInt(X(this).attr("time"));
                                p.start,
                                    p.end,
                                    e == o ? X(this).addClass("hovering") : X(this).removeClass("hovering"),
                                    p.start && !p.end && ((p.start < e && e <= o) || (p.start > e && o <= e)) ? X(this).addClass("hovering") : X(this).removeClass("hovering");
                            }),
                            p.start &&
                            !p.end &&
                            ((i = S(o, p.start)), p.hoveringTooltip && ("function" == typeof p.hoveringTooltip ? (r = p.hoveringTooltip(i, p.start, o)) : !0 === p.hoveringTooltip && 1 < i && (r = i + " " + V("days")))))),
                        r
                            ? ((t = e.offset()),
                                (i = l.offset()),
                                (n = t.left - i.left),
                                (s = t.top - i.top),
                                (n += e.width() / 2),
                                (e = (a = l.find(".date-range-length-tip")).css({ visibility: "hidden", display: "none" }).html(r).width()),
                                (r = a.height()),
                                (n -= e / 2),
                                (s -= r),
                                setTimeout(function () {
                                    a.css({ left: n, top: s, display: "block", visibility: "visible" });
                                }, 10))
                            : l.find(".date-range-length-tip").hide();
                }
                function b() {
                    l.find(".day.hovering").removeClass("hovering"), l.find(".date-range-length-tip").hide();
                }
                function _(e) {
                    var t = e.val(),
                        i = e.attr("name"),
                        n = e.parents("table").hasClass("month1") ? "month1" : "month2",
                        s = "month1" == n ? "month2" : "month1",
                        a = !!p.startDate && Z(p.startDate),
                        e = !!p.endDate && Z(p.endDate),
                        t = Z(p[n])[i](t);
                    a && t.isSameOrBefore(a) && (t = a.add("month2" == n ? 1 : 0, "month")),
                    e && t.isSameOrAfter(e) && (t = e.add(p.singleMonth || "month1" != n ? 0 : -1, "month")),
                        D(t, n),
                        "month1" == n ? (p.stickyMonths || Z(t).isSameOrAfter(p[s], "month")) && D(Z(t).add(1, "month"), s) : (p.stickyMonths || Z(t).isSameOrBefore(p[s], "month")) && D(Z(t).add(-1, "month"), s),
                        z();
                }
                function k() {
                    !0 === p.singleDate ? n && p.start && p.autoClose && L() : n && p.start && p.end && p.autoClose && L();
                }
                function x() {
                    var e = Math.ceil((p.end - p.start) / 864e5) + 1;
                    p.singleDate
                        ? p.start && !p.end
                            ? l.find(".drp_top-bar").removeClass("error").addClass("normal")
                            : l.find(".drp_top-bar").removeClass("error").removeClass("normal")
                        : p.maxDays && e > p.maxDays
                            ? ((p.start = !1), (p.end = !1), l.find(".day").removeClass("checked"), l.find(".drp_top-bar").removeClass("normal").addClass("error").find(".error-top").html(V("less-than").replace("%d", p.maxDays)))
                            : p.minDays && e < p.minDays
                                ? ((p.start = !1), (p.end = !1), l.find(".day").removeClass("checked"), l.find(".drp_top-bar").removeClass("normal").addClass("error").find(".error-top").html(V("more-than").replace("%d", p.minDays)))
                                : p.start || p.end
                                    ? l.find(".drp_top-bar").removeClass("error").addClass("normal")
                                    : l.find(".drp_top-bar").removeClass("error").removeClass("normal"),
                        (p.singleDate && p.start && !p.end) || (!p.singleDate && p.start && p.end) ? l.find(".apply-btn").removeClass("disabled") : l.find(".apply-btn").addClass("disabled"),
                    p.batchMode && ((p.start && p.startDate && Y(p.start, p.startDate) < 0) || (p.end && p.endDate && 0 < Y(p.end, p.endDate))) && ((p.start = !1), (p.end = !1), l.find(".day").removeClass("checked"));
                }
                function C(e, t) {
                    var i;
                    l.find(".start-day").html("..."),
                        l.find(".end-day").html("..."),
                        l.find(".selected-days").hide(),
                    p.start && l.find(".start-day").html(A(new Date(parseInt(p.start)))),
                    p.end && l.find(".end-day").html(A(new Date(parseInt(p.end)))),
                        p.start && p.singleDate
                            ? (l.find(".apply-btn").removeClass("disabled"),
                                (i = A(new Date(p.start))),
                                p.setValue.call(o, i, A(new Date(p.start)), A(new Date(p.end))),
                            n && !t && X(a).trigger("datepicker-change", { value: i, date1: new Date(p.start) }))
                            : p.start && p.end
                                ? (l.find(".selected-days").show().find(".selected-days-num").html(S(p.end, p.start)),
                                    l.find(".apply-btn").removeClass("disabled"),
                                    (i = A(new Date(p.start)) + p.separator + A(new Date(p.end))),
                                    p.setValue.call(o, i, A(new Date(p.start)), A(new Date(p.end))),
                                n && !t && X(a).trigger("datepicker-change", { value: i, date1: new Date(p.start), date2: new Date(p.end) }))
                                : e
                                    ? l.find(".apply-btn").removeClass("disabled")
                                    : l.find(".apply-btn").addClass("disabled");
                }
                function S(e, t) {
                    return Math.abs(Z(e).diff(Z(t), "d"));
                }
                function T(e, t, i) {
                    e.getTime() > t.getTime() && ((n = t), (t = e), (e = n), (n = null));
                    var n = !0;
                    if ((p.startDate && Y(e, p.startDate) < 0 && (n = !1), p.endDate && 0 < Y(t, p.endDate) && (n = !1), !n)) return D(p.startDate, "month1"), D(j(p.startDate), "month2"), z(), 0;
                    (p.start = e.getTime()),
                        (p.end = t.getTime()),
                    p.time.enabled && (u("time1", e), u("time2", t)),
                    (p.stickyMonths || (0 < Y(e, t) && 0 === N(e, t))) && (p.lookBehind ? (e = H(t)) : (t = j(e))),
                    p.stickyMonths && !1 !== p.endDate && 0 < N(t, p.endDate) && ((e = H(e)), (t = H(t))),
                    p.stickyMonths || (0 === N(e, t) && (p.lookBehind ? (e = H(t)) : (t = j(e)))),
                        D(e, "month1"),
                        D(t, "month2"),
                        z(),
                        x(),
                        C(!1, i),
                        k();
                }
                function $(e) {
                    var t = !0;
                    p.startDate && Y(e, p.startDate) < 0 && (t = !1),
                    p.endDate && 0 < Y(e, p.endDate) && (t = !1),
                        t ? ((p.start = e.getTime()), p.time.enabled && u("time1", e), D(e, "month1"), !0 !== p.singleMonth && D(j(e), "month2"), z(), C(), k()) : D(p.startDate, "month1");
                }
                function E() {
                    (p.start || p.end) &&
                    (l.find(".day").each(function () {
                        var e = parseInt(X(this).attr("time")),
                            t = p.start,
                            i = p.end;
                        p.time.enabled &&
                        ((e = Z(e).startOf("day").valueOf()),
                            (t = Z(t || Z().valueOf())
                                .startOf("day")
                                .valueOf()),
                            (i = Z(i || Z().valueOf())
                                .startOf("day")
                                .valueOf())),
                            (p.start && p.end && e <= i && t <= e) || (p.start && !p.end && Z(t).format("YYYY-MM-DD") == Z(e).format("YYYY-MM-DD")) ? X(this).addClass("checked") : X(this).removeClass("checked"),
                            p.start && Z(t).format("YYYY-MM-DD") == Z(e).format("YYYY-MM-DD") ? X(this).addClass("first-date-selected") : X(this).removeClass("first-date-selected"),
                            p.end && Z(i).format("YYYY-MM-DD") == Z(e).format("YYYY-MM-DD") ? X(this).addClass("last-date-selected") : X(this).removeClass("last-date-selected");
                    }),
                        l.find(".week-number").each(function () {
                            X(this).attr("data-start-time") == p.startWeek && X(this).addClass("week-number-selected");
                        }));
                }
                function D(o, e) {
                    var t = (function (e, t) {
                            var i = (e = Z(e)).get("month"),
                                n = '<div class="month-element">' + P(i) + "</div>";
                            if (!p.monthSelect) return n;
                            var s = !!p.startDate && Z(p.startDate).add(p.singleMonth || "month2" !== t ? 0 : 1, "month"),
                                a = !!p.endDate && Z(p.endDate).add(p.singleMonth || "month1" !== t ? 0 : -1, "month"),
                                t = s && e.isSame(s, "year") ? s.get("month") : 0,
                                s = a && e.isSame(a, "year") ? a.get("month") : 11,
                                e = Math.min(t, i),
                                a = Math.max(s, i);
                            return e === a ? n : O("month", M({ minSelectable: t, maxSelectable: s, minVisible: e, maxVisible: a }, i, P));
                        })((o = Z(o).toDate()), e),
                        i = (function (e) {
                            var t = Z(o).get("year"),
                                i = '<div class="month-element">' + t + "</div>";
                            if (!p.yearSelect) return i;
                            var n = p.yearSelect && "function" == typeof p.yearSelect,
                                s = !!p.startDate && Z(p.startDate).add(p.singleMonth || "month2" !== e ? 0 : 1, "month"),
                                a = !!p.endDate && Z(p.endDate).add(p.singleMonth || "month1" !== e ? 0 : -1, "month"),
                                e = n ? p.yearSelect(t) : p.yearSelect.slice(),
                                n = s ? Math.max(e[0], s.get("year")) : Math.min(e[0], t),
                                s = a ? Math.min(e[1], a.get("year")) : Math.max(e[1], t),
                                a = Math.min(n, t),
                                e = Math.max(s, t);
                            return a === e ? i : O("year", M({ minSelectable: n, maxSelectable: s, minVisible: a, maxVisible: e }, t));
                        })(e);
                    l.find("." + e + " .month-name").html(t + " " + i),
                        l.find("." + e + " tbody").html(
                            (function (e) {
                                var t = [];
                                e.setDate(1), new Date(e.getTime() - 864e5);
                                var i = new Date(),
                                    n = e.getDay();
                                if ((0 === n && "monday" === p.startOfWeek && (n = 7), 0 < n))
                                    for (var s = n; 0 < s; s--) {
                                        var a = g((d = new Date(e.getTime() - 864e5 * s)).getTime());
                                        p.startDate && Y(d, p.startDate) < 0 && (a = !1), p.endDate && 0 < Y(d, p.endDate) && (a = !1), t.push({ date: d, type: "lastMonth", day: d.getDate(), time: d.getTime(), valid: a });
                                    }
                                for (var o = e.getMonth(), s = 0; s < 40; s++)
                                    (a = g((c = Z(e).add(s, "days").toDate()).getTime())),
                                    p.startDate && Y(c, p.startDate) < 0 && (a = !1),
                                    p.endDate && 0 < Y(c, p.endDate) && (a = !1),
                                        t.push({ date: c, type: c.getMonth() == o ? "toMonth" : "nextMonth", day: c.getDate(), time: c.getTime(), valid: a });
                                for (var r = [], l = 0; l < 6 && "nextMonth" != t[7 * l].type; l++) {
                                    r.push("<tr>");
                                    for (var d = 0; d < 7; d++) {
                                        var c = t[7 * l + ("monday" == p.startOfWeek ? d + 1 : d)],
                                            u = Z(c.time).format("L") == Z(i).format("L");
                                        (c.extraClass = ""),
                                            (c.tooltip = ""),
                                        c.valid &&
                                        p.beforeShowDay &&
                                        "function" == typeof p.beforeShowDay &&
                                        ((h = p.beforeShowDay(Z(c.time).toDate())), (c.valid = h[0]), (c.extraClass = h[1] || ""), (c.tooltip = h[2] || ""), "" !== c.tooltip && (c.extraClass += " has-tooltip "));
                                        var h = { time: c.time, "data-tooltip": c.tooltip, class: "day " + c.type + " " + c.extraClass + " " + (c.valid ? "valid" : "invalid") + " " + (u ? "real-today" : "") };
                                        0 === d && p.showWeekNumbers && r.push('<td><div class="week-number" data-start-time="' + c.time + '">' + p.getWeekNumber(c.date) + "</div></td>"),
                                            r.push(
                                                "<td " +
                                                B({}, p.dayTdAttrs, c) +
                                                "><div " +
                                                B(h, p.dayDivAttrs, c) +
                                                ">" +
                                                ((u = c.time), (h = c.day), p.showDateFilter && "function" == typeof p.showDateFilter ? p.showDateFilter(u, h) : h) +
                                                "</div></td>"
                                            );
                                    }
                                    r.push("</tr>");
                                }
                                return r.join("");
                            })(o)
                        ),
                        (p[e] = o),
                        w(),
                        l
                            .find(".day")
                            .off("click")
                            .click(function (e) {
                                var t, i;
                                (t = X(this)).hasClass("invalid") ||
                                ((i = t.attr("time")),
                                    t.addClass("checked"),
                                    p.singleDate
                                        ? ((p.start = i), (p.end = !1))
                                        : "week" === p.batchMode
                                            ? "monday" === p.startOfWeek
                                                ? ((p.start = Z(parseInt(i)).startOf("isoweek").valueOf()), (p.end = Z(parseInt(i)).endOf("isoweek").valueOf()))
                                                : ((p.end = Z(parseInt(i)).endOf("week").valueOf()), (p.start = Z(parseInt(i)).startOf("week").valueOf()))
                                            : "workweek" === p.batchMode
                                                ? ((p.start = Z(parseInt(i)).day(1).valueOf()), (p.end = Z(parseInt(i)).day(5).valueOf()))
                                                : "weekend" === p.batchMode
                                                    ? ((p.start = Z(parseInt(i)).day(6).valueOf()), (p.end = Z(parseInt(i)).day(7).valueOf()))
                                                    : "month" === p.batchMode
                                                        ? ((p.start = Z(parseInt(i)).startOf("month").valueOf()), (p.end = Z(parseInt(i)).endOf("month").valueOf()))
                                                        : (p.start && p.end) || (!p.start && !p.end)
                                                            ? ((p.start = m(i)), (p.end = !1))
                                                            : p.start && ((p.end = v(i)), p.time.enabled && h("end", p.end)),
                                p.time.enabled && (p.start && h("start", p.start), p.end && h("end", p.end)),
                                !p.singleDate && p.start && p.end && p.start > p.end && ((i = p.end), (p.end = v(p.start)), (p.start = m(i)), p.time.enabled && p.swapTime && (u("time1", p.start), u("time2", p.end))),
                                    (p.start = parseInt(p.start)),
                                    (p.end = parseInt(p.end)),
                                    b(),
                                p.start && !p.end && (X(a).trigger("datepicker-first-date-selected", { date1: new Date(p.start) }), y(t)),
                                    w(),
                                    x(),
                                    C(),
                                    E(),
                                    k());
                            }),
                        l
                            .find(".day")
                            .off("mouseenter")
                            .mouseenter(function (e) {
                                y(X(this));
                            }),
                        l
                            .find(".day")
                            .off("mouseleave")
                            .mouseleave(function (e) {
                                l.find(".date-range-length-tip").hide(), p.singleDate && b();
                            }),
                        l
                            .find(".week-number")
                            .off("click")
                            .click(function (e) {
                                var t,
                                    i,
                                    n = X(this),
                                    s = parseInt(n.attr("data-start-time"), 10);
                                p.startWeek
                                    ? (l.find(".week-number-selected").removeClass("week-number-selected"),
                                        (t = new Date(s < p.startWeek ? s : p.startWeek)),
                                        (i = new Date(s < p.startWeek ? p.startWeek : s)),
                                        (p.startWeek = !1),
                                        (p.start = Z(t)
                                            .day("monday" == p.startOfWeek ? 1 : 0)
                                            .valueOf()),
                                        (p.end = Z(i)
                                            .day("monday" == p.startOfWeek ? 7 : 6)
                                            .valueOf()))
                                    : ((p.startWeek = s),
                                        n.addClass("week-number-selected"),
                                        (t = new Date(s)),
                                        (p.start = Z(t)
                                            .day("monday" == p.startOfWeek ? 1 : 0)
                                            .valueOf()),
                                        (p.end = Z(t)
                                            .day("monday" == p.startOfWeek ? 7 : 6)
                                            .valueOf())),
                                    w(),
                                    x(),
                                    C(),
                                    E(),
                                    k();
                            }),
                        l
                            .find(".month")
                            .off("change")
                            .change(function (e) {
                                _(X(this));
                            }),
                        l
                            .find(".year")
                            .off("change")
                            .change(function (e) {
                                _(X(this));
                            });
                }
                function M(e, t, i) {
                    var n = [];
                    i =
                        i ||
                        function (e) {
                            return e;
                        };
                    for (var s = e.minVisible; s <= e.maxVisible; s++) n.push({ value: s, text: i(s), selected: s === t, disabled: s < e.minSelectable || s > e.maxSelectable });
                    return n;
                }
                function O(e, t) {
                    for (var i, n = '<div class="select-wrapper"><select class="' + e + '" name="' + e + '">', s = 0, a = t.length; s < a; s++) {
                        var o = t[s];
                        (n += '<option value="' + o.value + '"' + (o.selected ? " selected" : "") + (o.disabled ? " disabled" : "") + ">" + o.text + "</option>"), o.selected && (i = o.text);
                    }
                    return n + "</select>" + i + "</div>";
                }
                function I(e, t) {
                    l
                        .find("." + t)
                        .append(
                            "<div><span>" +
                            V("Time") +
                            ': <span class="hour-val">00</span>:<span class="minute-val">00</span></span></div><div class="hour"><label>' +
                            V("Hour") +
                            ': <input type="range" class="hour-range" name="hour" min="0" max="23"></label></div><div class="minute"><label>' +
                            V("Minute") +
                            ': <input type="range" class="minute-range" name="minute" min="0" max="59"></label></div>'
                        ),
                        u(t, e);
                }
                function P(e) {
                    return V("month-name")[e];
                }
                function A(e) {
                    return Z(e).format(p.format);
                }
                function z() {
                    E();
                    var e = parseInt(Z(p.month1).format("YYYYMM")),
                        t = parseInt(Z(p.month2).format("YYYYMM")),
                        e = Math.abs(e - t);
                    1 < e && 89 != e ? l.addClass("has-gap").removeClass("no-gap").find(".gap").css("visibility", "visible") : l.removeClass("has-gap").addClass("no-gap").find(".gap").css("visibility", "hidden");
                    (t = l.find("table.month1").height()), (e = l.find("table.month2").height());
                    l.find(".gap").height(Math.max(t, e) + 10);
                }
                function L() {
                    var e;
                    p.alwaysOpen ||
                    ((e = function () {
                        X(a).data("date-picker-opened", !1), X(a).trigger("datepicker-closed", { relatedTarget: l });
                    }),
                        p.customCloseAnimation ? p.customCloseAnimation.call(l.get(0), e) : X(l).slideUp(p.duration, e),
                        X(a).trigger("datepicker-close", { relatedTarget: l }));
                }
                function W() {
                    D(p.month1, "month1"), D(p.month2, "month2");
                }
                function N(e, t) {
                    t = parseInt(Z(e).format("YYYYMM")) - parseInt(Z(t).format("YYYYMM"));
                    return 0 < t ? 1 : 0 == t ? 0 : -1;
                }
                function Y(e, t) {
                    t = parseInt(Z(e).format("YYYYMMDD")) - parseInt(Z(t).format("YYYYMMDD"));
                    return 0 < t ? 1 : 0 == t ? 0 : -1;
                }
                function j(e) {
                    return Z(e).add(1, "months").toDate();
                }
                function H(e) {
                    return Z(e).add(-1, "months").toDate();
                }
                function R() {
                    var e = p.showWeekNumbers ? "<th>" + V("week-number") + "</th>" : "";
                    return "monday" == p.startOfWeek
                        ? e + "<th>" + V("week-1") + "</th><th>" + V("week-2") + "</th><th>" + V("week-3") + "</th><th>" + V("week-4") + "</th><th>" + V("week-5") + "</th><th>" + V("week-6") + "</th><th>" + V("week-7") + "</th>"
                        : e + "<th>" + V("week-7") + "</th><th>" + V("week-1") + "</th><th>" + V("week-2") + "</th><th>" + V("week-3") + "</th><th>" + V("week-4") + "</th><th>" + V("week-5") + "</th><th>" + V("week-6") + "</th>";
                }
                function F(e) {
                    return (e = Z(e)), (p.startDate && e.endOf("month").isBefore(p.startDate)) || (p.endDate && e.startOf("month").isAfter(p.endDate));
                }
                function B(e, t, s) {
                    var a = X.extend(!0, {}, e);
                    X.each(t, function (e, t) {
                        var i,
                            n = t(s);
                        for (i in n) a.hasOwnProperty(i) ? (a[i] += n[i]) : (a[i] = n[i]);
                    });
                    var i,
                        n = "";
                    for (i in a) a.hasOwnProperty(i) && (n += i + '="' + a[i] + '" ');
                    return n;
                }
                function V(e) {
                    var t = e.toLowerCase(),
                        i = e in s ? s[e] : t in s ? s[t] : null,
                        n = X.dateRangePickerLanguages.default;
                    return null == i && (i = e in n ? n[e] : t in n ? n[t] : ""), i;
                }
                function U() {
                    var e = p.defaultTime || new Date();
                    return (
                        p.lookBehind
                            ? (p.startDate && N(e, p.startDate) < 0 && (e = j(Z(p.startDate).toDate())), p.endDate && 0 < N(e, p.endDate) && (e = Z(p.endDate).toDate()))
                            : (p.startDate && N(e, p.startDate) < 0 && (e = Z(p.startDate).toDate()), p.endDate && 0 < N(j(e), p.endDate) && (e = H(Z(p.endDate).toDate()))),
                        p.singleDate && (p.startDate && N(e, p.startDate) < 0 && (e = Z(p.startDate).toDate()), p.endDate && 0 < N(e, p.endDate) && (e = Z(p.endDate).toDate())),
                            e
                    );
                }
                function G(e) {
                    (e = e || U()), p.lookBehind ? (D(H(e), "month1"), D(e, "month2")) : (D(e, "month1"), D(j(e), "month2")), p.singleDate && D(e, "month1"), E(), z();
                }
                function q(e) {
                    var t = e;
                    (e = a[0]).contains(t.target) || t.target == e || (null != e.childNodes && 0 <= X.inArray(t.target, e.childNodes)) || (l.is(":visible") && L());
                }
            });
    }),
    (function (e, t) {
        "function" == typeof define && define.amd ? define(t) : "object" == typeof exports ? (module.exports = t()) : (e.PhotoSwipe = t());
    })(this, function () {
        "use strict";
        return function (p, i, e, t) {
            var f = {
                features: null,
                bind: function (e, t, i, n) {
                    var s = (n ? "remove" : "add") + "EventListener";
                    t = t.split(" ");
                    for (var a = 0; a < t.length; a++) t[a] && e[s](t[a], i, !1);
                },
                isArray: function (e) {
                    return e instanceof Array;
                },
                createEl: function (e, t) {
                    t = document.createElement(t || "div");
                    return e && (t.className = e), t;
                },
                getScrollY: function () {
                    var e = window.pageYOffset;
                    return void 0 !== e ? e : document.documentElement.scrollTop;
                },
                unbind: function (e, t, i) {
                    f.bind(e, t, i, !0);
                },
                removeClass: function (e, t) {
                    t = new RegExp("(\\s|^)" + t + "(\\s|$)");
                    e.className = e.className
                        .replace(t, " ")
                        .replace(/^\s\s*/, "")
                        .replace(/\s\s*$/, "");
                },
                addClass: function (e, t) {
                    f.hasClass(e, t) || (e.className += (e.className ? " " : "") + t);
                },
                hasClass: function (e, t) {
                    return e.className && new RegExp("(^|\\s)" + t + "(\\s|$)").test(e.className);
                },
                getChildByClass: function (e, t) {
                    for (var i = e.firstChild; i; ) {
                        if (f.hasClass(i, t)) return i;
                        i = i.nextSibling;
                    }
                },
                arraySearch: function (e, t, i) {
                    for (var n = e.length; n--; ) if (e[n][i] === t) return n;
                    return -1;
                },
                extend: function (e, t, i) {
                    for (var n in t)
                        if (t.hasOwnProperty(n)) {
                            if (i && e.hasOwnProperty(n)) continue;
                            e[n] = t[n];
                        }
                },
                easing: {
                    sine: {
                        out: function (e) {
                            return Math.sin(e * (Math.PI / 2));
                        },
                        inOut: function (e) {
                            return -(Math.cos(Math.PI * e) - 1) / 2;
                        },
                    },
                    cubic: {
                        out: function (e) {
                            return --e * e * e + 1;
                        },
                    },
                },
                detectFeatures: function () {
                    if (f.features) return f.features;
                    var e,
                        t,
                        i = f.createEl().style,
                        n = "",
                        s = {};
                    (s.oldIE = document.all && !document.addEventListener),
                        (s.touch = "ontouchstart" in window),
                    window.requestAnimationFrame && ((s.raf = window.requestAnimationFrame), (s.caf = window.cancelAnimationFrame)),
                        (s.pointerEvent = navigator.pointerEnabled || navigator.msPointerEnabled),
                    s.pointerEvent ||
                    ((e = navigator.userAgent),
                    !/iP(hone|od)/.test(navigator.platform) || ((t = navigator.appVersion.match(/OS (\d+)_(\d+)_?(\d+)?/)) && 0 < t.length && 1 <= (t = parseInt(t[1], 10)) && t < 8 && (s.isOldIOSPhone = !0)),
                        (t = (t = e.match(/Android\s([0-9\.]*)/)) ? t[1] : 0),
                    1 <= (t = parseFloat(t)) && (t < 4.4 && (s.isOldAndroid = !0), (s.androidVersion = t)),
                        (s.isMobileOpera = /opera mini|opera mobi/i.test(e)));
                    for (var a, o, r, l = ["transform", "perspective", "animationName"], d = ["", "webkit", "Moz", "ms", "O"], c = 0; c < 4; c++) {
                        n = d[c];
                        for (var u = 0; u < 3; u++) (a = l[u]), (o = n + (n ? a.charAt(0).toUpperCase() + a.slice(1) : a)), !s[a] && o in i && (s[a] = o);
                        n && !s.raf && ((n = n.toLowerCase()), (s.raf = window[n + "RequestAnimationFrame"]), s.raf && (s.caf = window[n + "CancelAnimationFrame"] || window[n + "CancelRequestAnimationFrame"]));
                    }
                    return (
                        s.raf ||
                        ((r = 0),
                            (s.raf = function (e) {
                                var t = new Date().getTime(),
                                    i = Math.max(0, 16 - (t - r)),
                                    n = window.setTimeout(function () {
                                        e(t + i);
                                    }, i);
                                return (r = t + i), n;
                            }),
                            (s.caf = function (e) {
                                clearTimeout(e);
                            })),
                            (s.svg = !!document.createElementNS && !!document.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect),
                            (f.features = s)
                    );
                },
            };
            f.detectFeatures(),
            f.features.oldIE &&
            (f.bind = function (e, t, i, n) {
                t = t.split(" ");
                for (
                    var s,
                        a = (n ? "detach" : "attach") + "Event",
                        o = function () {
                            i.handleEvent.call(i);
                        },
                        r = 0;
                    r < t.length;
                    r++
                )
                    if ((s = t[r]))
                        if ("object" == typeof i && i.handleEvent) {
                            if (n) {
                                if (!i["oldIE" + s]) return !1;
                            } else i["oldIE" + s] = o;
                            e[a]("on" + s, i["oldIE" + s]);
                        } else e[a]("on" + s, i);
            });
            var m = this,
                v = {
                    allowPanToNext: !0,
                    spacing: 0.12,
                    bgOpacity: 1,
                    mouseUsed: !1,
                    loop: !0,
                    pinchToClose: !0,
                    closeOnScroll: !0,
                    closeOnVerticalDrag: !0,
                    verticalDragRange: 0.75,
                    hideAnimationDuration: 333,
                    showAnimationDuration: 333,
                    showHideOpacity: !1,
                    focus: !0,
                    escKey: !0,
                    arrowKeys: !0,
                    mainScrollEndFriction: 0.35,
                    panEndFriction: 0.35,
                    isClickableElement: function (e) {
                        return "A" === e.tagName;
                    },
                    getDoubleTapZoom: function (e, t) {
                        return e || t.initialZoomLevel < 0.7 ? 1 : 1.33;
                    },
                    maxSpreadZoom: 1.33,
                    modal: !0,
                    scaleMode: "fit",
                };
            f.extend(v, t);
            function n() {
                return { x: 0, y: 0 };
            }
            function s(e, t) {
                f.extend(m, t.publicMethods), Ze.push(e);
            }
            function o(e) {
                var t = Vt();
                return t - 1 < e ? e - t : e < 0 ? t + e : e;
            }
            function a(e, t) {
                return Je[e] || (Je[e] = []), Je[e].push(t);
            }
            function g(e) {
                var t = Je[e];
                if (t) {
                    var i = Array.prototype.slice.call(arguments);
                    i.shift();
                    for (var n = 0; n < t.length; n++) t[n].apply(m, i);
                }
            }
            function c() {
                return new Date().getTime();
            }
            function w(e) {
                (Ne = e), (m.bg.style.opacity = e * v.bgOpacity);
            }
            function r(e, t, i, n, s) {
                (!Qe || (s && s !== m.currItem)) && (n /= (s || m.currItem).fitRatio), (e[re] = K + t + "px, " + i + "px" + Q + " scale(" + n + ")");
            }
            function u(e, t) {
                var i;
                !v.loop && t && ((i = F + (Ge.x * Ve - e) / Ge.x), (t = Math.round(e - yt.x)), ((i < 0 && 0 < t) || (i >= Vt() - 1 && t < 0)) && (e = yt.x + t * v.mainScrollEndFriction)), (yt.x = e), it(e, B);
            }
            function l(e, t) {
                var i = bt[e] - Ue[e];
                return Re[e] + He[e] + i - (t / Z) * i;
            }
            function y(e, t) {
                (e.x = t.x), (e.y = t.y), t.id && (e.id = t.id);
            }
            function d(e) {
                (e.x = Math.round(e.x)), (e.y = Math.round(e.y));
            }
            function h(e, t) {
                return (e = Zt(m.currItem, Be, e)), t && (Ie = e), e;
            }
            function b(e) {
                return (e = e || m.currItem).initialZoomLevel;
            }
            function _(e) {
                return 0 < (e = e || m.currItem).w ? v.maxSpreadZoom : 1;
            }
            function k(e, t, i, n) {
                return n === m.currItem.initialZoomLevel ? ((i[e] = m.currItem.initialPosition[e]), !0) : ((i[e] = l(e, n)), i[e] > t.min[e] ? ((i[e] = t.min[e]), !0) : i[e] < t.max[e] && ((i[e] = t.max[e]), !0));
            }
            function x(e) {
                var t = "";
                v.escKey && 27 === e.keyCode ? (t = "close") : v.arrowKeys && (37 === e.keyCode ? (t = "prev") : 39 === e.keyCode && (t = "next")),
                t && (e.ctrlKey || e.altKey || e.shiftKey || e.metaKey || (e.preventDefault ? e.preventDefault() : (e.returnValue = !1), m[t]()));
            }
            function C(e) {
                e && (Te || Se || Ae || _e) && (e.preventDefault(), e.stopPropagation());
            }
            function S() {
                m.setScrollOffset(0, f.getScrollY());
            }
            function T(e) {
                at[e] && (at[e].raf && ue(at[e].raf), ot--, delete at[e]);
            }
            function $(e) {
                at[e] && T(e), at[e] || (ot++, (at[e] = {}));
            }
            function E() {
                for (var e in at) at.hasOwnProperty(e) && T(e);
            }
            function D(e, t, i, n, s, a, o) {
                var r,
                    l = c();
                $(e);
                var d = function () {
                    if (at[e]) {
                        if (((r = c() - l), n <= r)) return T(e), a(i), void (o && o());
                        a((i - t) * s(r / n) + t), (at[e].raf = ce(d));
                    }
                };
                d();
            }
            function M(e, t) {
                return (mt.x = Math.abs(e.x - t.x)), (mt.y = Math.abs(e.y - t.y)), Math.sqrt(mt.x * mt.x + mt.y * mt.y);
            }
            function O(e, t) {
                return (St.prevent = !Ct(e.target, v.isClickableElement)), g("preventDragEvent", e, t, St), St.prevent;
            }
            function I(e, t) {
                return (t.x = e.pageX), (t.y = e.pageY), (t.id = e.identifier), t;
            }
            function P(e, t, i) {
                (i.x = 0.5 * (e.x + t.x)), (i.y = 0.5 * (e.y + t.y));
            }
            function A() {
                var e = Fe.y - m.currItem.initialPosition.y;
                return 1 - Math.abs(e / (Be.y / 2));
            }
            function z(e) {
                for (; 0 < Et.length; ) Et.pop();
                return (
                    le
                        ? ((je = 0),
                            ht.forEach(function (e) {
                                0 === je ? (Et[0] = e) : 1 === je && (Et[1] = e), je++;
                            }))
                        : -1 < e.type.indexOf("touch")
                            ? e.touches && 0 < e.touches.length && ((Et[0] = I(e.touches[0], Tt)), 1 < e.touches.length && (Et[1] = I(e.touches[1], $t)))
                            : ((Tt.x = e.pageX), (Tt.y = e.pageY), (Tt.id = ""), (Et[0] = Tt)),
                        Et
                );
            }
            function L(e, t) {
                var i,
                    n,
                    s,
                    a = Fe[e] + t[e],
                    o = 0 < t[e],
                    r = yt.x + t.x,
                    l = yt.x - pt.x,
                    d = a > Ie.min[e] || a < Ie.max[e] ? v.panEndFriction : 1,
                    a = Fe[e] + t[e] * d;
                return (!v.allowPanToNext && X !== m.currItem.initialZoomLevel) ||
                (Pe
                    ? "h" !== ze ||
                    "x" !== e ||
                    Se ||
                    (o
                        ? (a > Ie.min[e] && ((d = v.panEndFriction), Ie.min[e], (i = Ie.min[e] - Re[e])), (i <= 0 || l < 0) && 1 < Vt() ? ((s = r), l < 0 && r > pt.x && (s = pt.x)) : Ie.min.x !== Ie.max.x && (n = a))
                        : (a < Ie.max[e] && ((d = v.panEndFriction), Ie.max[e], (i = Re[e] - Ie.max[e])), (i <= 0 || 0 < l) && 1 < Vt() ? ((s = r), 0 < l && r < pt.x && (s = pt.x)) : Ie.min.x !== Ie.max.x && (n = a)))
                    : (s = r),
                "x" !== e)
                    ? void (Ae || Ee || (X > m.currItem.fitRatio && (Fe[e] += t[e] * d)))
                    : (void 0 !== s && (u(s, !0), (Ee = s !== pt.x)), Ie.min.x !== Ie.max.x && (void 0 !== n ? (Fe.x = n) : Ee || (Fe.x += t.x * d)), void 0 !== s);
            }
            function W(e) {
                var t;
                ("mousedown" === e.type && 0 < e.button) ||
                (Ft
                    ? e.preventDefault()
                    : (ke && "mousedown" === e.type) ||
                    (O(e, !0) && e.preventDefault(),
                        g("pointerDown"),
                    le && ((t = f.arraySearch(ht, e.pointerId, "id")) < 0 && (t = ht.length), (ht[t] = { x: e.pageX, y: e.pageY, id: e.pointerId })),
                        (e = (t = z(e)).length),
                        (De = null),
                        E(),
                    (xe && 1 !== e) ||
                    ((xe = Le = !0),
                        f.bind(window, U, m),
                        (be = Ye = We = _e = Ee = Te = Ce = Se = !1),
                        (ze = null),
                        g("firstTouchStart", t),
                        y(Re, Fe),
                        (He.x = He.y = 0),
                        y(ct, t[0]),
                        y(ut, ct),
                        (pt.x = Ge.x * Ve),
                        (ft = [{ x: ct.x, y: ct.y }]),
                        (we = ge = c()),
                        h(X, !0),
                        kt(),
                        xt()),
                    !Me &&
                    1 < e &&
                    !Ae &&
                    !Ee &&
                    ((Z = X), (Me = Ce = !(Se = !1)), (He.y = He.x = 0), y(Re, Fe), y(rt, t[0]), y(lt, t[1]), P(rt, lt, _t), (bt.x = Math.abs(_t.x) - Fe.x), (bt.y = Math.abs(_t.y) - Fe.y), (Oe = M(rt, lt)))));
            }
            function N(e) {
                var t, i;
                e.preventDefault(),
                le && -1 < (t = f.arraySearch(ht, e.pointerId, "id")) && (((i = ht[t]).x = e.pageX), (i.y = e.pageY)),
                xe && ((i = z(e)), ze || Te || Me ? (De = i) : yt.x !== Ge.x * Ve ? (ze = "h") : ((e = Math.abs(i[0].x - ct.x) - Math.abs(i[0].y - ct.y)), 10 <= Math.abs(e) && ((ze = 0 < e ? "h" : "v"), (De = i))));
            }
            function Y(e) {
                if (ve.isOldAndroid) {
                    if (ke && "mouseup" === e.type) return;
                    -1 < e.type.indexOf("touch") &&
                    (clearTimeout(ke),
                        (ke = setTimeout(function () {
                            ke = 0;
                        }, 600)));
                }
                g("pointerUp"),
                O(e, !1) && e.preventDefault(),
                !le ||
                (-1 < (i = f.arraySearch(ht, e.pointerId, "id")) &&
                    ((a = ht.splice(i, 1)[0]), navigator.pointerEnabled ? (a.type = e.pointerType || "mouse") : ((a.type = { 4: "mouse", 2: "touch", 3: "pen" }[e.pointerType]), a.type || (a.type = e.pointerType || "mouse"))));
                var t = z(e),
                    i = t.length;
                if (("mouseup" === e.type && (i = 0), 2 === i)) return !(De = null);
                1 === i && y(ut, t[0]),
                0 !== i ||
                ze ||
                Ae ||
                (a || ("mouseup" === e.type ? (a = { x: e.pageX, y: e.pageY, type: "mouse" }) : e.changedTouches && e.changedTouches[0] && (a = { x: e.changedTouches[0].pageX, y: e.changedTouches[0].pageY, type: "touch" })),
                    g("touchRelease", e, a));
                var n,
                    s,
                    a = -1;
                if (
                    (0 === i && ((xe = !1), f.unbind(window, U, m), kt(), Me ? (a = 0) : -1 !== wt && (a = c() - wt)),
                        (wt = 1 === i ? c() : -1),
                        (a = -1 !== a && a < 150 ? "zoom" : "swipe"),
                    Me && i < 2 && ((Me = !1), 1 === i && (a = "zoomPointerUp"), g("zoomGestureEnded")),
                        (De = null),
                    Te || Se || Ae || _e)
                )
                    if ((E(), (ye = ye || Mt()).calculateSwipeSpeed("x"), _e))
                        A() < v.verticalDragRange
                            ? m.close()
                            : ((n = Fe.y),
                                (s = Ne),
                                D("verticalDrag", 0, 1, 300, f.easing.cubic.out, function (e) {
                                    (Fe.y = (m.currItem.initialPosition.y - n) * e + n), w((1 - s) * e + s), et();
                                }),
                                g("onVerticalDrag", 1));
                    else {
                        if ((Ee || Ae) && 0 === i) {
                            if (It(a, ye)) return;
                            a = "zoomPointerUp";
                        }
                        if (!Ae) return "swipe" !== a ? void At() : void (!Ee && X > m.currItem.fitRatio && Ot(ye));
                    }
            }
            var j,
                H,
                R,
                F,
                B,
                V,
                U,
                G,
                q,
                X,
                Z,
                K,
                Q,
                J,
                ee,
                te,
                ie,
                ne,
                se,
                ae,
                oe,
                re,
                le,
                de,
                ce,
                ue,
                he,
                pe,
                fe,
                me,
                ve,
                ge,
                we,
                ye,
                be,
                _e,
                ke,
                xe,
                Ce,
                Se,
                Te,
                $e,
                Ee,
                De,
                Me,
                Oe,
                Ie,
                Pe,
                Ae,
                ze,
                Le,
                We,
                Ne,
                Ye,
                je,
                He = n(),
                Re = n(),
                Fe = n(),
                Be = {},
                Ve = 0,
                Ue = {},
                Ge = n(),
                qe = 0,
                Xe = !0,
                Ze = [],
                Ke = {},
                Qe = !1,
                Je = {},
                et = function (e) {
                    Pe && (e && (X > m.currItem.fitRatio ? Qe || (Kt(m.currItem, !1, !0), (Qe = !0)) : Qe && (Kt(m.currItem), (Qe = !1))), r(Pe, Fe.x, Fe.y, X));
                },
                tt = function (e) {
                    e.container && r(e.container.style, e.initialPosition.x, e.initialPosition.y, e.initialZoomLevel, e);
                },
                it = function (e, t) {
                    t[re] = K + e + "px, 0px" + Q;
                },
                nt = null,
                st = function () {
                    nt && (f.unbind(document, "mousemove", st), f.addClass(p, "pswp--has_mouse"), (v.mouseUsed = !0), g("mouseUsed")),
                        (nt = setTimeout(function () {
                            nt = null;
                        }, 100));
                },
                at = {},
                ot = 0,
                t = {
                    shout: g,
                    listen: a,
                    viewportSize: Be,
                    options: v,
                    isMainScrollAnimating: function () {
                        return Ae;
                    },
                    getZoomLevel: function () {
                        return X;
                    },
                    getCurrentIndex: function () {
                        return F;
                    },
                    isDragging: function () {
                        return xe;
                    },
                    isZooming: function () {
                        return Me;
                    },
                    setScrollOffset: function (e, t) {
                        (Ue.x = e), (me = Ue.y = t), g("updateScrollOffset", Ue);
                    },
                    applyZoomPan: function (e, t, i, n) {
                        (Fe.x = t), (Fe.y = i), (X = e), et(n);
                    },
                    init: function () {
                        if (!j && !H) {
                            var e;
                            (m.framework = f),
                                (m.template = p),
                                (m.bg = f.getChildByClass(p, "pswp__bg")),
                                (he = p.className),
                                (j = !0),
                                (ve = f.detectFeatures()),
                                (ce = ve.raf),
                                (ue = ve.caf),
                                (re = ve.transform),
                                (fe = ve.oldIE),
                                (m.scrollWrap = f.getChildByClass(p, "pswp__scroll-wrap")),
                                (m.container = f.getChildByClass(m.scrollWrap, "pswp__container")),
                                (B = m.container.style),
                                (m.itemHolders = te = [
                                    { el: m.container.children[0], wrap: 0, index: -1 },
                                    { el: m.container.children[1], wrap: 0, index: -1 },
                                    { el: m.container.children[2], wrap: 0, index: -1 },
                                ]),
                                (te[0].el.style.display = te[2].el.style.display = "none"),
                                (function () {
                                    if (re) {
                                        var e = ve.perspective && !de;
                                        return (K = "translate" + (e ? "3d(" : "(")), (Q = ve.perspective ? ", 0px)" : ")");
                                    }
                                    (re = "left"),
                                        f.addClass(p, "pswp--ie"),
                                        (it = function (e, t) {
                                            t.left = e + "px";
                                        }),
                                        (tt = function (e) {
                                            var t = 1 < e.fitRatio ? 1 : e.fitRatio,
                                                i = e.container.style,
                                                n = t * e.w,
                                                t = t * e.h;
                                            (i.width = n + "px"), (i.height = t + "px"), (i.left = e.initialPosition.x + "px"), (i.top = e.initialPosition.y + "px");
                                        }),
                                        (et = function () {
                                            var e, t, i, n;
                                            Pe && ((e = Pe), (i = (t = 1 < (n = m.currItem).fitRatio ? 1 : n.fitRatio) * n.w), (n = t * n.h), (e.width = i + "px"), (e.height = n + "px"), (e.left = Fe.x + "px"), (e.top = Fe.y + "px"));
                                        });
                                })(),
                                (q = { resize: m.updateSize, scroll: S, keydown: x, click: C });
                            var t = ve.isOldIOSPhone || ve.isOldAndroid || ve.isMobileOpera;
                            for ((ve.animationName && ve.transform && !t) || (v.showAnimationDuration = v.hideAnimationDuration = 0), e = 0; e < Ze.length; e++) m["init" + Ze[e]]();
                            i && (m.ui = new i(m, f)).init(),
                                g("firstUpdate"),
                                (F = F || v.index || 0),
                            (isNaN(F) || F < 0 || F >= Vt()) && (F = 0),
                                (m.currItem = Bt(F)),
                            (ve.isOldIOSPhone || ve.isOldAndroid) && (Xe = !1),
                                p.setAttribute("aria-hidden", "false"),
                            v.modal && (Xe ? (p.style.position = "fixed") : ((p.style.position = "absolute"), (p.style.top = f.getScrollY() + "px"))),
                            void 0 === me && (g("initialLayout"), (me = pe = f.getScrollY()));
                            t = "pswp--open ";
                            for (
                                v.mainClass && (t += v.mainClass + " "),
                                v.showHideOpacity && (t += "pswp--animate_opacity "),
                                    t += de ? "pswp--touch" : "pswp--notouch",
                                    t += ve.animationName ? " pswp--css_animation" : "",
                                    t += ve.svg ? " pswp--svg" : "",
                                    f.addClass(p, t),
                                    m.updateSize(),
                                    V = -1,
                                    qe = null,
                                    e = 0;
                                e < 3;
                                e++
                            )
                                it((e + V) * Ge.x, te[e].el.style);
                            fe || f.bind(m.scrollWrap, G, m),
                                a("initialZoomInEnd", function () {
                                    m.setContent(te[0], F - 1),
                                        m.setContent(te[2], F + 1),
                                        (te[0].el.style.display = te[2].el.style.display = "block"),
                                    v.focus && p.focus(),
                                        f.bind(document, "keydown", m),
                                    ve.transform && f.bind(m.scrollWrap, "click", m),
                                    v.mouseUsed || f.bind(document, "mousemove", st),
                                        f.bind(window, "resize scroll", m),
                                        g("bindEvents");
                                }),
                                m.setContent(te[1], F),
                                m.updateCurrItem(),
                                g("afterInit"),
                            Xe ||
                            (J = setInterval(function () {
                                ot || xe || Me || X !== m.currItem.initialZoomLevel || m.updateSize();
                            }, 1e3)),
                                f.addClass(p, "pswp--visible");
                        }
                    },
                    close: function () {
                        j &&
                        ((H = !(j = !1)),
                            g("close"),
                            f.unbind(window, "resize", m),
                            f.unbind(window, "scroll", q.scroll),
                            f.unbind(document, "keydown", m),
                            f.unbind(document, "mousemove", st),
                        ve.transform && f.unbind(m.scrollWrap, "click", m),
                        xe && f.unbind(window, U, m),
                            g("unbindEvents"),
                            Ut(m.currItem, null, !0, m.destroy));
                    },
                    destroy: function () {
                        g("destroy"), jt && clearTimeout(jt), p.setAttribute("aria-hidden", "true"), (p.className = he), J && clearInterval(J), f.unbind(m.scrollWrap, G, m), f.unbind(window, "scroll", m), kt(), E(), (Je = null);
                    },
                    panTo: function (e, t, i) {
                        i || (e > Ie.min.x ? (e = Ie.min.x) : e < Ie.max.x && (e = Ie.max.x), t > Ie.min.y ? (t = Ie.min.y) : t < Ie.max.y && (t = Ie.max.y)), (Fe.x = e), (Fe.y = t), et();
                    },
                    handleEvent: function (e) {
                        (e = e || window.event), q[e.type] && q[e.type](e);
                    },
                    goTo: function (e) {
                        var t = (e = o(e)) - F;
                        (qe = t), (F = e), (m.currItem = Bt(F)), (Ve -= t), u(Ge.x * Ve), E(), (Ae = !1), m.updateCurrItem();
                    },
                    next: function () {
                        m.goTo(F + 1);
                    },
                    prev: function () {
                        m.goTo(F - 1);
                    },
                    updateCurrZoomItem: function (e) {
                        var t;
                        e && g("beforeChange", 0),
                            (Pe = te[1].el.children.length ? ((t = te[1].el.children[0]), f.hasClass(t, "pswp__zoom-wrap") ? t.style : null) : null),
                            (Ie = m.currItem.bounds),
                            (Z = X = m.currItem.initialZoomLevel),
                            (Fe.x = Ie.center.x),
                            (Fe.y = Ie.center.y),
                        e && g("afterChange");
                    },
                    invalidateCurrItems: function () {
                        ee = !0;
                        for (var e = 0; e < 3; e++) te[e].item && (te[e].item.needsUpdate = !0);
                    },
                    updateCurrItem: function (e) {
                        if (0 !== qe) {
                            var t,
                                i = Math.abs(qe);
                            if (!(e && i < 2)) {
                                (m.currItem = Bt(F)), (Qe = !1), g("beforeChange", qe), 3 <= i && ((V += qe + (0 < qe ? -3 : 3)), (i = 3));
                                for (var n = 0; n < i; n++)
                                    0 < qe
                                        ? ((t = te.shift()), (te[2] = t), it((++V + 2) * Ge.x, t.el.style), m.setContent(t, F - i + n + 1 + 1))
                                        : ((t = te.pop()), te.unshift(t), it(--V * Ge.x, t.el.style), m.setContent(t, F + i - n - 1 - 1));
                                !Pe || 1 !== Math.abs(qe) || ((e = Bt(ie)).initialZoomLevel !== X && (Zt(e, Be), Kt(e), tt(e))), (qe = 0), m.updateCurrZoomItem(), (ie = F), g("afterChange");
                            }
                        }
                    },
                    updateSize: function (e) {
                        if (!Xe && v.modal) {
                            var t = f.getScrollY();
                            if ((me !== t && ((p.style.top = t + "px"), (me = t)), !e && Ke.x === window.innerWidth && Ke.y === window.innerHeight)) return;
                            (Ke.x = window.innerWidth), (Ke.y = window.innerHeight), (p.style.height = Ke.y + "px");
                        }
                        if (((Be.x = m.scrollWrap.clientWidth), (Be.y = m.scrollWrap.clientHeight), S(), (Ge.x = Be.x + Math.round(Be.x * v.spacing)), (Ge.y = Be.y), u(Ge.x * Ve), g("beforeResize"), void 0 !== V)) {
                            for (var i, n, s, a = 0; a < 3; a++)
                                (i = te[a]),
                                    it((a + V) * Ge.x, i.el.style),
                                    (s = F + a - 1),
                                v.loop && 2 < Vt() && (s = o(s)),
                                    (n = Bt(s)) && (ee || n.needsUpdate || !n.bounds)
                                        ? (m.cleanSlide(n), m.setContent(i, s), 1 === a && ((m.currItem = n), m.updateCurrZoomItem(!0)), (n.needsUpdate = !1))
                                        : -1 === i.index && 0 <= s && m.setContent(i, s),
                                n && n.container && (Zt(n, Be), Kt(n), tt(n));
                            ee = !1;
                        }
                        (Z = X = m.currItem.initialZoomLevel), (Ie = m.currItem.bounds) && ((Fe.x = Ie.center.x), (Fe.y = Ie.center.y), et(!0)), g("resize");
                    },
                    zoomTo: function (t, e, i, n, s) {
                        e && ((Z = X), (bt.x = Math.abs(e.x) - Fe.x), (bt.y = Math.abs(e.y) - Fe.y), y(Re, Fe));
                        var e = h(t, !1),
                            a = {};
                        k("x", e, a, t), k("y", e, a, t);
                        var o = X,
                            r = Fe.x,
                            l = Fe.y;
                        d(a);
                        e = function (e) {
                            1 === e ? ((X = t), (Fe.x = a.x), (Fe.y = a.y)) : ((X = (t - o) * e + o), (Fe.x = (a.x - r) * e + r), (Fe.y = (a.y - l) * e + l)), s && s(e), et(1 === e);
                        };
                        i ? D("customZoomTo", 0, 1, i, n || f.easing.sine.inOut, e) : e(1);
                    },
                },
                rt = {},
                lt = {},
                dt = {},
                ct = {},
                ut = {},
                ht = [],
                pt = {},
                ft = [],
                mt = {},
                vt = 0,
                gt = n(),
                wt = 0,
                yt = n(),
                bt = n(),
                _t = n(),
                kt = function () {
                    $e && (ue($e), ($e = null));
                },
                xt = function () {
                    xe && (($e = ce(xt)), Dt());
                },
                Ct = function (e, t) {
                    return !!e && !(e.className && -1 < e.className.indexOf("pswp__scroll-wrap")) && (t(e) ? e : Ct(e.parentNode, t));
                },
                St = {},
                Tt = {},
                $t = {},
                Et = [],
                Dt = function () {
                    if (De) {
                        var e = De.length;
                        if (0 !== e)
                            if ((y(rt, De[0]), (dt.x = rt.x - ct.x), (dt.y = rt.y - ct.y), Me && 1 < e))
                                (ct.x = rt.x),
                                    (ct.y = rt.y),
                                (dt.x || dt.y || ((a = De[1]), (o = lt), a.x !== o.x || a.y !== o.y)) &&
                                (y(lt, De[1]),
                                Se || ((Se = !0), g("zoomGestureStarted")),
                                    (n = M(rt, lt)),
                                (s = Pt(n)) > m.currItem.initialZoomLevel + m.currItem.initialZoomLevel / 15 && (Ye = !0),
                                    (i = 1),
                                    (e = b()),
                                    (a = _()),
                                    s < e
                                        ? v.pinchToClose && !Ye && Z <= m.currItem.initialZoomLevel
                                            ? (w((o = 1 - (e - s) / (e / 1.2))), g("onPinchClose", o), (We = !0))
                                            : (1 < (i = (e - s) / e) && (i = 1), (s = e - i * (e / 3)))
                                        : a < s && (1 < (i = (s - a) / (6 * e)) && (i = 1), (s = a + i * e)),
                                i < 0 && (i = 0),
                                    P(rt, lt, gt),
                                    (He.x += gt.x - _t.x),
                                    (He.y += gt.y - _t.y),
                                    y(_t, gt),
                                    (Fe.x = l("x", s)),
                                    (Fe.y = l("y", s)),
                                    (be = X < s),
                                    (X = s),
                                    et());
                            else if (ze && (Le && ((Le = !1), 10 <= Math.abs(dt.x) && (dt.x -= De[0].x - ut.x), 10 <= Math.abs(dt.y) && (dt.y -= De[0].y - ut.y)), (ct.x = rt.x), (ct.y = rt.y), 0 !== dt.x || 0 !== dt.y)) {
                                if ("v" === ze && v.closeOnVerticalDrag && "fit" === v.scaleMode && X === m.currItem.initialZoomLevel) {
                                    (He.y += dt.y), (Fe.y += dt.y);
                                    var t = A();
                                    return (_e = !0), g("onVerticalDrag", t), w(t), void et();
                                }
                                (i = c()),
                                    (n = rt.x),
                                    (s = rt.y),
                                50 < i - we && (((t = 2 < ft.length ? ft.shift() : {}).x = n), (t.y = s), ft.push(t), (we = i)),
                                    (Te = !0),
                                    (Ie = m.currItem.bounds),
                                L("x", dt) || (L("y", dt), d(Fe), et());
                            }
                    }
                    var i, n, s, a, o;
                },
                Mt = function () {
                    var t,
                        i,
                        n = {
                            lastFlickOffset: {},
                            lastFlickDist: {},
                            lastFlickSpeed: {},
                            slowDownRatio: {},
                            slowDownRatioReverse: {},
                            speedDecelerationRatio: {},
                            speedDecelerationRatioAbs: {},
                            distanceOffset: {},
                            backAnimDestination: {},
                            backAnimStarted: {},
                            calculateSwipeSpeed: function (e) {
                                (i = 1 < ft.length ? ((t = c() - we + 50), ft[ft.length - 2][e]) : ((t = c() - ge), ut[e])),
                                    (n.lastFlickOffset[e] = ct[e] - i),
                                    (n.lastFlickDist[e] = Math.abs(n.lastFlickOffset[e])),
                                    20 < n.lastFlickDist[e] ? (n.lastFlickSpeed[e] = n.lastFlickOffset[e] / t) : (n.lastFlickSpeed[e] = 0),
                                Math.abs(n.lastFlickSpeed[e]) < 0.1 && (n.lastFlickSpeed[e] = 0),
                                    (n.slowDownRatio[e] = 0.95),
                                    (n.slowDownRatioReverse[e] = 1 - n.slowDownRatio[e]),
                                    (n.speedDecelerationRatio[e] = 1);
                            },
                            calculateOverBoundsAnimOffset: function (t, e) {
                                n.backAnimStarted[t] ||
                                (Fe[t] > Ie.min[t] ? (n.backAnimDestination[t] = Ie.min[t]) : Fe[t] < Ie.max[t] && (n.backAnimDestination[t] = Ie.max[t]),
                                void 0 !== n.backAnimDestination[t] &&
                                ((n.slowDownRatio[t] = 0.7),
                                    (n.slowDownRatioReverse[t] = 1 - n.slowDownRatio[t]),
                                n.speedDecelerationRatioAbs[t] < 0.05 &&
                                ((n.lastFlickSpeed[t] = 0),
                                    (n.backAnimStarted[t] = !0),
                                    D("bounceZoomPan" + t, Fe[t], n.backAnimDestination[t], e || 300, f.easing.sine.out, function (e) {
                                        (Fe[t] = e), et();
                                    }))));
                            },
                            calculateAnimOffset: function (e) {
                                n.backAnimStarted[e] ||
                                ((n.speedDecelerationRatio[e] = n.speedDecelerationRatio[e] * (n.slowDownRatio[e] + n.slowDownRatioReverse[e] - (n.slowDownRatioReverse[e] * n.timeDiff) / 10)),
                                    (n.speedDecelerationRatioAbs[e] = Math.abs(n.lastFlickSpeed[e] * n.speedDecelerationRatio[e])),
                                    (n.distanceOffset[e] = n.lastFlickSpeed[e] * n.speedDecelerationRatio[e] * n.timeDiff),
                                    (Fe[e] += n.distanceOffset[e]));
                            },
                            panAnimLoop: function () {
                                return at.zoomPan &&
                                ((at.zoomPan.raf = ce(n.panAnimLoop)),
                                    (n.now = c()),
                                    (n.timeDiff = n.now - n.lastNow),
                                    (n.lastNow = n.now),
                                    n.calculateAnimOffset("x"),
                                    n.calculateAnimOffset("y"),
                                    et(),
                                    n.calculateOverBoundsAnimOffset("x"),
                                    n.calculateOverBoundsAnimOffset("y"),
                                n.speedDecelerationRatioAbs.x < 0.05 && n.speedDecelerationRatioAbs.y < 0.05)
                                    ? ((Fe.x = Math.round(Fe.x)), (Fe.y = Math.round(Fe.y)), et(), void T("zoomPan"))
                                    : void 0;
                            },
                        };
                    return n;
                },
                Ot = function (e) {
                    return (
                        e.calculateSwipeSpeed("y"),
                            (Ie = m.currItem.bounds),
                            (e.backAnimDestination = {}),
                            (e.backAnimStarted = {}),
                            Math.abs(e.lastFlickSpeed.x) <= 0.05 && Math.abs(e.lastFlickSpeed.y) <= 0.05
                                ? ((e.speedDecelerationRatioAbs.x = e.speedDecelerationRatioAbs.y = 0), e.calculateOverBoundsAnimOffset("x"), e.calculateOverBoundsAnimOffset("y"), !0)
                                : ($("zoomPan"), (e.lastNow = c()), void e.panAnimLoop())
                    );
                },
                It = function (e, t) {
                    var i, n;
                    Ae || (vt = F),
                    "swipe" === e && ((n = ct.x - ut.x), (e = t.lastFlickDist.x < 10), 30 < n && (e || 20 < t.lastFlickOffset.x) ? (a = -1) : n < -30 && (e || t.lastFlickOffset.x < -20) && (a = 1)),
                    a && ((F += a) < 0 ? ((F = v.loop ? Vt() - 1 : 0), (s = !0)) : F >= Vt() && ((F = v.loop ? 0 : Vt() - 1), (s = !0)), (s && !v.loop) || ((qe += a), (Ve -= a), (i = !0)));
                    var s = Ge.x * Ve,
                        a = Math.abs(s - yt.x),
                        o = i || s > yt.x == 0 < t.lastFlickSpeed.x ? ((o = 0 < Math.abs(t.lastFlickSpeed.x) ? a / Math.abs(t.lastFlickSpeed.x) : 333), (o = Math.min(o, 400)), Math.max(o, 250)) : 333;
                    return (
                        vt === F && (i = !1),
                            (Ae = !0),
                            g("mainScrollAnimStart"),
                            D("mainScroll", yt.x, s, o, f.easing.cubic.out, u, function () {
                                E(), (Ae = !1), (vt = -1), (!i && vt === F) || m.updateCurrItem(), g("mainScrollAnimComplete");
                            }),
                        i && m.updateCurrItem(!0),
                            i
                    );
                },
                Pt = function (e) {
                    return (1 / Oe) * e * Z;
                },
                At = function () {
                    var e = X,
                        t = b(),
                        i = _();
                    X < t ? (e = t) : i < X && (e = i);
                    var n,
                        s = Ne;
                    return (
                        We && !be && !Ye && X < t
                            ? m.close()
                            : (We &&
                            (n = function (e) {
                                w((1 - s) * e + s);
                            }),
                                m.zoomTo(e, 0, 200, f.easing.cubic.out, n)),
                            !0
                    );
                };
            s("Gestures", {
                publicMethods: {
                    initGestures: function () {
                        function e(e, t, i, n, s) {
                            (ne = e + t), (se = e + i), (ae = e + n), (oe = s ? e + s : "");
                        }
                        (le = ve.pointerEvent) && ve.touch && (ve.touch = !1),
                            le
                                ? navigator.pointerEnabled
                                    ? e("pointer", "down", "move", "up", "cancel")
                                    : e("MSPointer", "Down", "Move", "Up", "Cancel")
                                : ve.touch
                                    ? (e("touch", "start", "move", "end", "cancel"), (de = !0))
                                    : e("mouse", "down", "move", "up"),
                            (U = se + " " + ae + " " + oe),
                            (G = ne),
                        le && !de && (de = 1 < navigator.maxTouchPoints || 1 < navigator.msMaxTouchPoints),
                            (m.likelyTouchDevice = de),
                            (q[ne] = W),
                            (q[se] = N),
                            (q[ae] = Y),
                        oe && (q[oe] = q[ae]),
                        ve.touch && ((G += " mousedown"), (U += " mousemove mouseup"), (q.mousedown = q[ne]), (q.mousemove = q[se]), (q.mouseup = q[ae])),
                        de || (v.allowPanToNext = !1);
                    },
                },
            });
            function zt() {
                return { center: { x: 0, y: 0 }, max: { x: 0, y: 0 }, min: { x: 0, y: 0 } };
            }
            function Lt(e, t, i, n, s, a) {
                t.loadError ||
                (n &&
                    ((t.imageAppended = !0),
                        Kt(t, n),
                        i.appendChild(n),
                    a &&
                    setTimeout(function () {
                        t && t.loaded && t.placeholder && ((t.placeholder.style.display = "none"), (t.placeholder = null));
                    }, 500)));
            }
            function Wt(e) {
                function t() {
                    (e.loading = !1), (e.loaded = !0), e.loadComplete ? e.loadComplete(e) : (e.img = null), (i.onload = i.onerror = null), (i = null);
                }
                (e.loading = !0), (e.loaded = !1);
                var i = (e.img = f.createEl("pswp__img", "img"));
                return (
                    (i.onload = t),
                        (i.onerror = function () {
                            (e.loadError = !0), t();
                        }),
                        (i.src = e.src),
                        i
                );
            }
            function Nt(e, t) {
                return e.src && e.loadError && e.container ? (t && (e.container.innerHTML = ""), (e.container.innerHTML = v.errorMsg.replace("%url%", e.src)), !0) : void 0;
            }
            function Yt() {
                if (qt.length) {
                    for (var e, t = 0; t < qt.length; t++) (e = qt[t]).holder.index === e.index && Lt(e.index, e.item, e.baseDiv, e.img, 0, e.clearPlaceholder);
                    qt = [];
                }
            }
            var jt,
                Ht,
                Rt,
                Ft,
                Bt,
                Vt,
                Ut = function (o, e, r, t) {
                    var l;
                    jt && clearTimeout(jt), (Rt = Ft = !0), o.initialLayout ? ((l = o.initialLayout), (o.initialLayout = null)) : (l = v.getThumbBoundsFn && v.getThumbBoundsFn(F));
                    function d() {
                        T("initialZoom"),
                            r ? (m.template.removeAttribute("style"), m.bg.removeAttribute("style")) : (w(1), e && (e.style.display = "block"), f.addClass(p, "pswp--animated-in"), g("initialZoom" + (r ? "OutEnd" : "InEnd"))),
                        t && t(),
                            (Ft = !1);
                    }
                    var c = r ? v.hideAnimationDuration : v.showAnimationDuration;
                    if (!c || !l || void 0 === l.x)
                        return (
                            g("initialZoom" + (r ? "Out" : "In")),
                                (X = o.initialZoomLevel),
                                y(Fe, o.initialPosition),
                                et(),
                                (p.style.opacity = r ? 0 : 1),
                                w(1),
                                void (c
                                    ? setTimeout(function () {
                                        d();
                                    }, c)
                                    : d())
                        );
                    var u, h;
                    (u = R),
                        (h = !m.currItem.src || m.currItem.loadError || v.showHideOpacity),
                    o.miniImg && (o.miniImg.style.webkitBackfaceVisibility = "hidden"),
                    r || ((X = l.w / o.w), (Fe.x = l.x), (Fe.y = l.y - pe), (m[h ? "template" : "bg"].style.opacity = 0.001), et()),
                        $("initialZoom"),
                    r && !u && f.removeClass(p, "pswp--animated-in"),
                    h &&
                    (r
                        ? f[(u ? "remove" : "add") + "Class"](p, "pswp--animate_opacity")
                        : setTimeout(function () {
                            f.addClass(p, "pswp--animate_opacity");
                        }, 30)),
                        (jt = setTimeout(
                            function () {
                                var t, i, n, s, a, e;
                                g("initialZoom" + (r ? "Out" : "In")),
                                    r
                                        ? ((t = l.w / o.w),
                                            (i = Fe.x),
                                            (n = Fe.y),
                                            (s = X),
                                            (a = Ne),
                                            (e = function (e) {
                                                1 === e ? ((X = t), (Fe.x = l.x), (Fe.y = l.y - me)) : ((X = (t - s) * e + s), (Fe.x = (l.x - i) * e + i), (Fe.y = (l.y - me - n) * e + n)), et(), h ? (p.style.opacity = 1 - e) : w(a - e * a);
                                            }),
                                            u ? D("initialZoom", 0, 1, c, f.easing.cubic.out, e, d) : (e(1), (jt = setTimeout(d, c + 20))))
                                        : ((X = o.initialZoomLevel), y(Fe, o.initialPosition), et(), w(1), h ? (p.style.opacity = 1) : w(1), (jt = setTimeout(d, c + 20)));
                            },
                            r ? 25 : 90
                        ));
                },
                Gt = {},
                qt = [],
                Xt = {
                    index: 0,
                    errorMsg: '<div class="pswp__error-msg"><a href="%url%" target="_blank">The image</a> could not be loaded.</div>',
                    forceProgressiveLoading: !1,
                    preload: [1, 1],
                    getNumItemsFn: function () {
                        return Ht.length;
                    },
                },
                Zt = function (e, t, i) {
                    if (!e.src || e.loadError) return (e.w = e.h = 0), (e.initialZoomLevel = e.fitRatio = 1), (e.bounds = zt()), (e.initialPosition = e.bounds.center), e.bounds;
                    var n,
                        s,
                        a,
                        o = !i;
                    return (
                        o && (e.vGap || (e.vGap = { top: 0, bottom: 0 }), g("parseVerticalMargin", e)),
                            (Gt.x = t.x),
                            (Gt.y = t.y - e.vGap.top - e.vGap.bottom),
                        o &&
                        ((n = Gt.x / e.w),
                            (s = Gt.y / e.h),
                            (e.fitRatio = n < s ? n : s),
                            "orig" === (a = v.scaleMode) ? (i = 1) : "fit" === a && (i = e.fitRatio),
                        1 < i && (i = 1),
                            (e.initialZoomLevel = i),
                        e.bounds || (e.bounds = zt())),
                            i
                                ? ((n = (t = e).w * i),
                                    (s = e.h * i),
                                    ((a = t.bounds).center.x = Math.round((Gt.x - n) / 2)),
                                    (a.center.y = Math.round((Gt.y - s) / 2) + t.vGap.top),
                                    (a.max.x = n > Gt.x ? Math.round(Gt.x - n) : a.center.x),
                                    (a.max.y = s > Gt.y ? Math.round(Gt.y - s) + t.vGap.top : a.center.y),
                                    (a.min.x = n > Gt.x ? 0 : a.center.x),
                                    (a.min.y = s > Gt.y ? t.vGap.top : a.center.y),
                                o && i === e.initialZoomLevel && (e.initialPosition = e.bounds.center),
                                    e.bounds)
                                : void 0
                    );
                },
                Kt = function (e, t, i) {
                    var n;
                    e.src &&
                    ((t = t || e.container.lastChild),
                        (n = i ? e.w : Math.round(e.w * e.fitRatio)),
                        (i = i ? e.h : Math.round(e.h * e.fitRatio)),
                    e.placeholder && !e.loaded && ((e.placeholder.style.width = n + "px"), (e.placeholder.style.height = i + "px")),
                        (t.style.width = n + "px"),
                        (t.style.height = i + "px"));
                };
            s("Controller", {
                publicMethods: {
                    lazyLoadItem: function (e) {
                        e = o(e);
                        var t = Bt(e);
                        t && ((!t.loaded && !t.loading) || ee) && (g("gettingData", e, t), t.src && Wt(t));
                    },
                    initController: function () {
                        f.extend(v, Xt, !0),
                            (m.items = Ht = e),
                            (Bt = m.getItemAt),
                            (Vt = v.getNumItemsFn),
                            v.loop,
                        Vt() < 3 && (v.loop = !1),
                            a("beforeChange", function (e) {
                                for (var t = v.preload, i = null === e || 0 <= e, n = Math.min(t[0], Vt()), s = Math.min(t[1], Vt()), a = 1; a <= (i ? s : n); a++) m.lazyLoadItem(F + a);
                                for (a = 1; a <= (i ? n : s); a++) m.lazyLoadItem(F - a);
                            }),
                            a("initialLayout", function () {
                                m.currItem.initialLayout = v.getThumbBoundsFn && v.getThumbBoundsFn(F);
                            }),
                            a("mainScrollAnimComplete", Yt),
                            a("initialZoomInEnd", Yt),
                            a("destroy", function () {
                                for (var e, t = 0; t < Ht.length; t++)
                                    (e = Ht[t]).container && (e.container = null), e.placeholder && (e.placeholder = null), e.img && (e.img = null), e.preloader && (e.preloader = null), e.loadError && (e.loaded = e.loadError = !1);
                                qt = null;
                            });
                    },
                    getItemAt: function (e) {
                        return 0 <= e && void 0 !== Ht[e] && Ht[e];
                    },
                    allowProgressiveImg: function () {
                        return v.forceProgressiveLoading || !de || v.mouseUsed || 1200 < screen.width;
                    },
                    setContent: function (t, i) {
                        v.loop && (i = o(i));
                        var e = m.getItemAt(t.index);
                        e && (e.container = null);
                        var n,
                            s,
                            a = m.getItemAt(i);
                        a
                            ? (g("gettingData", i, a),
                                (t.index = i),
                                (s = (t.item = a).container = f.createEl("pswp__zoom-wrap")),
                            !a.src && a.html && (a.html.tagName ? s.appendChild(a.html) : (s.innerHTML = a.html)),
                                Nt(a),
                                Zt(a, Be),
                                !a.src || a.loadError || a.loaded
                                    ? a.src && !a.loadError && (((n = f.createEl("pswp__img", "img")).style.opacity = 1), (n.src = a.src), Kt(a, n), Lt(0, a, s, n))
                                    : ((a.loadComplete = function (e) {
                                        if (j) {
                                            if (t && t.index === i) {
                                                if (Nt(e, !0)) return (e.loadComplete = e.img = null), Zt(e, Be), tt(e), void (t.index === F && m.updateCurrZoomItem());
                                                e.imageAppended
                                                    ? !Ft && e.placeholder && ((e.placeholder.style.display = "none"), (e.placeholder = null))
                                                    : ve.transform && (Ae || Ft)
                                                        ? qt.push({ item: e, baseDiv: s, img: e.img, index: i, holder: t, clearPlaceholder: !0 })
                                                        : Lt(0, e, s, e.img, 0, !0);
                                            }
                                            (e.loadComplete = null), (e.img = null), g("imageLoadComplete", i, e);
                                        }
                                    }),
                                    f.features.transform &&
                                    ((e = "pswp__img pswp__img--placeholder"),
                                        (e += a.msrc ? "" : " pswp__img--placeholder--blank"),
                                        (e = f.createEl(e, a.msrc ? "img" : "")),
                                    a.msrc && (e.src = a.msrc),
                                        Kt(a, e),
                                        s.appendChild(e),
                                        (a.placeholder = e)),
                                    a.loading || Wt(a),
                                    m.allowProgressiveImg() && (!Rt && ve.transform ? qt.push({ item: a, baseDiv: s, img: a.img, index: i, holder: t }) : Lt(0, a, s, a.img, 0, !0))),
                                Rt || i !== F ? tt(a) : ((Pe = s.style), Ut(a, n || a.img)),
                                (t.el.innerHTML = ""),
                                t.el.appendChild(s))
                            : (t.el.innerHTML = "");
                    },
                    cleanSlide: function (e) {
                        e.img && (e.img.onload = e.img.onerror = null), (e.loaded = e.loading = e.img = e.imageAppended = !1);
                    },
                },
            });
            function Qt(e, t, i) {
                var n = document.createEvent("CustomEvent"),
                    i = { origEvent: e, target: e.target, releasePoint: t, pointerType: i || "touch" };
                n.initCustomEvent("pswpTap", !0, !0, i), e.target.dispatchEvent(n);
            }
            var Jt,
                ei,
                ti = {};
            s("Tap", {
                publicMethods: {
                    initTap: function () {
                        a("firstTouchStart", m.onTapStart),
                            a("touchRelease", m.onTapRelease),
                            a("destroy", function () {
                                (ti = {}), (Jt = null);
                            });
                    },
                    onTapStart: function (e) {
                        1 < e.length && (clearTimeout(Jt), (Jt = null));
                    },
                    onTapRelease: function (e, t) {
                        var i, n, s;
                        !t ||
                        Te ||
                        Ce ||
                        ot ||
                        ((i = t),
                            Jt && (clearTimeout(Jt), (Jt = null), (n = i), (s = ti), Math.abs(n.x - s.x) < 25 && Math.abs(n.y - s.y) < 25)
                                ? g("doubleTap", i)
                                : "mouse" !== t.type
                                    ? "BUTTON" === e.target.tagName.toUpperCase() || f.hasClass(e.target, "pswp__single-tap")
                                        ? Qt(e, t)
                                        : (y(ti, i),
                                            (Jt = setTimeout(function () {
                                                Qt(e, t), (Jt = null);
                                            }, 300)))
                                    : Qt(e, t, "mouse"));
                    },
                },
            }),
                s("DesktopZoom", {
                    publicMethods: {
                        initDesktopZoom: function () {
                            fe ||
                            (de
                                ? a("mouseUsed", function () {
                                    m.setupDesktopZoom();
                                })
                                : m.setupDesktopZoom(!0));
                        },
                        setupDesktopZoom: function (e) {
                            ei = {};
                            var t = "wheel mousewheel DOMMouseScroll";
                            a("bindEvents", function () {
                                f.bind(p, t, m.handleMouseWheel);
                            }),
                                a("unbindEvents", function () {
                                    ei && f.unbind(p, t, m.handleMouseWheel);
                                }),
                                (m.mouseZoomedIn = !1);
                            function i() {
                                m.mouseZoomedIn && (f.removeClass(p, "pswp--zoomed-in"), (m.mouseZoomedIn = !1)), X < 1 ? f.addClass(p, "pswp--zoom-allowed") : f.removeClass(p, "pswp--zoom-allowed"), s();
                            }
                            var n,
                                s = function () {
                                    n && (f.removeClass(p, "pswp--dragging"), (n = !1));
                                };
                            a("resize", i),
                                a("afterChange", i),
                                a("pointerDown", function () {
                                    m.mouseZoomedIn && ((n = !0), f.addClass(p, "pswp--dragging"));
                                }),
                                a("pointerUp", s),
                            e || i();
                        },
                        handleMouseWheel: function (e) {
                            if (X <= m.currItem.fitRatio) return v.modal && (!v.closeOnScroll || ot || xe ? e.preventDefault() : re && 2 < Math.abs(e.deltaY) && ((R = !0), m.close())), !0;
                            if ((e.stopPropagation(), (ei.x = 0), "deltaX" in e)) 1 === e.deltaMode ? ((ei.x = 18 * e.deltaX), (ei.y = 18 * e.deltaY)) : ((ei.x = e.deltaX), (ei.y = e.deltaY));
                            else if ("wheelDelta" in e) e.wheelDeltaX && (ei.x = -0.16 * e.wheelDeltaX), e.wheelDeltaY ? (ei.y = -0.16 * e.wheelDeltaY) : (ei.y = -0.16 * e.wheelDelta);
                            else {
                                if (!("detail" in e)) return;
                                ei.y = e.detail;
                            }
                            h(X, !0);
                            var t = Fe.x - ei.x,
                                i = Fe.y - ei.y;
                            (v.modal || (t <= Ie.min.x && t >= Ie.max.x && i <= Ie.min.y && i >= Ie.max.y)) && e.preventDefault(), m.panTo(t, i);
                        },
                        toggleDesktopZoom: function (e) {
                            e = e || { x: Be.x / 2 + Ue.x, y: Be.y / 2 + Ue.y };
                            var t = v.getDoubleTapZoom(!0, m.currItem),
                                i = X === t;
                            (m.mouseZoomedIn = !i), m.zoomTo(i ? m.currItem.initialZoomLevel : t, e, 333), f[(i ? "remove" : "add") + "Class"](p, "pswp--zoomed-in");
                        },
                    },
                });
            function ii() {
                return mi.hash.substring(1);
            }
            function ni() {
                ai && clearTimeout(ai), ri && clearTimeout(ri);
            }
            function si() {
                var e = ii(),
                    t = {};
                if (e.length < 5) return t;
                var i,
                    n = e.split("&");
                for (a = 0; a < n.length; a++) n[a] && ((i = n[a].split("=")).length < 2 || (t[i[0]] = i[1]));
                if (v.galleryPIDs) {
                    for (var s = t.pid, a = (t.pid = 0); a < Ht.length; a++)
                        if (Ht[a].pid === s) {
                            t.pid = a;
                            break;
                        }
                } else t.pid = parseInt(t.pid, 10) - 1;
                return t.pid < 0 && (t.pid = 0), t;
            }
            var ai,
                oi,
                ri,
                li,
                di,
                ci,
                ui,
                hi,
                pi,
                fi,
                mi,
                vi,
                gi = { history: !0, galleryUID: 1 },
                wi = function () {
                    var e, t;
                    ri && clearTimeout(ri),
                        ot || xe
                            ? (ri = setTimeout(wi, 500))
                            : (li ? clearTimeout(oi) : (li = !0),
                                (t = F + 1),
                            (e = Bt(F)).hasOwnProperty("pid") && (t = e.pid),
                                (e = ui + "&gid=" + v.galleryUID + "&pid=" + t),
                            hi || (-1 === mi.hash.indexOf(e) && (fi = !0)),
                                (t = mi.href.split("#")[0] + "#" + e),
                                vi ? "#" + e !== window.location.hash && history[hi ? "replaceState" : "pushState"]("", document.title, t) : hi ? mi.replace(t) : (mi.hash = e),
                                (hi = !0),
                                (oi = setTimeout(function () {
                                    li = !1;
                                }, 60)));
                };
            s("History", {
                publicMethods: {
                    initHistory: function () {
                        var e, t;
                        f.extend(v, gi, !0),
                        v.history &&
                        ((mi = window.location),
                            (hi = pi = fi = !1),
                            (ui = ii()),
                            (vi = "pushState" in history),
                        -1 < ui.indexOf("gid=") && (ui = (ui = ui.split("&gid=")[0]).split("?gid=")[0]),
                            a("afterChange", m.updateURL),
                            a("unbindEvents", function () {
                                f.unbind(window, "hashchange", m.onHashChange);
                            }),
                            (e = function () {
                                (ci = !0), pi || (fi ? history.back() : ui ? (mi.hash = ui) : vi ? history.pushState("", document.title, mi.pathname + mi.search) : (mi.hash = "")), ni();
                            }),
                            a("unbindEvents", function () {
                                R && e();
                            }),
                            a("destroy", function () {
                                ci || e();
                            }),
                            a("firstUpdate", function () {
                                F = si().pid;
                            }),
                        -1 < (t = ui.indexOf("pid=")) && "&" === (ui = ui.substring(0, t)).slice(-1) && (ui = ui.slice(0, -1)),
                            setTimeout(function () {
                                j && f.bind(window, "hashchange", m.onHashChange);
                            }, 40));
                    },
                    onHashChange: function () {
                        return ii() === ui ? ((pi = !0), void m.close()) : void (li || ((di = !0), m.goTo(si().pid), (di = !1)));
                    },
                    updateURL: function () {
                        ni(), di || (hi ? (ai = setTimeout(wi, 800)) : wi());
                    },
                },
            }),
                f.extend(m, t);
        };
    }),
    (function (e, t) {
        "function" == typeof define && define.amd ? define(t) : "object" == typeof exports ? (module.exports = t()) : (e.PhotoSwipeUI_Default = t());
    })(this, function () {
        "use strict";
        return function (n, r) {
            function e(e) {
                if ($) return !0;
                (e = e || window.event), T.timeToIdle && T.mouseUsed && !b && W();
                for (var t, i, n = (e.target || e.srcElement).className, s = 0; s < Y.length; s++) (t = Y[s]).onTap && -1 < n.indexOf("pswp__" + t.name) && (t.onTap(), (i = !0));
                i &&
                (e.stopPropagation && e.stopPropagation(),
                    ($ = !0),
                    (e = r.features.isOldAndroid ? 600 : 30),
                    setTimeout(function () {
                        $ = !1;
                    }, e));
            }
            function t(e, t, i) {
                r[(i ? "add" : "remove") + "Class"](e, "pswp__" + t);
            }
            function i() {
                var e = 1 === T.getNumItemsFn();
                e !== S && (t(p, "ui--one-slide", e), (S = e));
            }
            function s() {
                t(w, "share-modal--hidden", P);
            }
            function a() {
                return (
                    (P = !P)
                        ? (r.removeClass(w, "pswp__share-modal--fade-in"),
                            setTimeout(function () {
                                P && s();
                            }, 300))
                        : (s(),
                            setTimeout(function () {
                                P || r.addClass(w, "pswp__share-modal--fade-in");
                            }, 30)),
                    P || z(),
                        0
                );
            }
            function o(e) {
                var t = (e = e || window.event).target || e.srcElement;
                return (
                    n.shout("shareLinkClick", e, t),
                    !!t.href &&
                    (!!t.hasAttribute("download") ||
                        (window.open(t.href, "pswp_share", "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,top=100,left=" + (window.screen ? Math.round(screen.width / 2 - 275) : 100)), P || a(), !1))
                );
            }
            function l(e) {
                for (var t = 0; t < T.closeElClasses.length; t++) if (r.hasClass(e, "pswp__" + T.closeElClasses[t])) return !0;
            }
            function d(e) {
                ((e = (e = e || window.event).relatedTarget || e.toElement) && "HTML" !== e.nodeName) ||
                (clearTimeout(D),
                    (D = setTimeout(function () {
                        M.setIdle(!0);
                    }, T.timeToIdleOutside)));
            }
            function c(e) {
                var t,
                    i = e.vGap;
                !n.likelyTouchDevice || T.mouseUsed || 1200 < screen.width
                    ? ((t = T.barsSize),
                        T.captionEl && "auto" === t.bottom
                            ? (m || ((m = r.createEl("pswp__caption pswp__caption--fake")).appendChild(r.createEl("pswp__caption__center")), p.insertBefore(m, f), r.addClass(p, "pswp__ui--fit")),
                                T.addCaptionHTMLFn(e, m, !0) ? ((e = m.clientHeight), (i.bottom = parseInt(e, 10) || 44)) : (i.bottom = t.top))
                            : (i.bottom = "auto" === t.bottom ? 0 : t.bottom),
                        (i.top = t.top))
                    : (i.top = i.bottom = 0);
            }
            function u() {
                function e(e) {
                    if (e)
                        for (var t = e.length, i = 0; i < t; i++) {
                            (s = e[i]), (a = s.className);
                            for (var n = 0; n < Y.length; n++)
                                (o = Y[n]), -1 < a.indexOf("pswp__" + o.name) && (T[o.option] ? (r.removeClass(s, "pswp__element--disabled"), o.onInit && o.onInit(s)) : r.addClass(s, "pswp__element--disabled"));
                        }
                }
                var s, a, o;
                e(p.children);
                var t = r.getChildByClass(p, "pswp__top-bar");
                t && e(t.children);
            }
            var h,
                p,
                f,
                m,
                v,
                g,
                w,
                y,
                b,
                _,
                k,
                x,
                C,
                S,
                T,
                $,
                E,
                D,
                M = this,
                O = !1,
                I = !0,
                P = !0,
                A = {
                    barsSize: { top: 44, bottom: "auto" },
                    closeElClasses: ["item", "caption", "zoom-wrap", "ui", "top-bar"],
                    timeToIdle: 4e3,
                    timeToIdleOutside: 1e3,
                    loadingIndicatorDelay: 1e3,
                    addCaptionHTMLFn: function (e, t) {
                        return e.title ? ((t.children[0].innerHTML = e.title), !0) : ((t.children[0].innerHTML = ""), !1);
                    },
                    closeEl: !0,
                    captionEl: !0,
                    fullscreenEl: !0,
                    zoomEl: !0,
                    shareEl: !0,
                    counterEl: !0,
                    arrowEl: !0,
                    preloaderEl: !0,
                    tapToClose: !1,
                    tapToToggleControls: !0,
                    clickToCloseNonZoomable: !0,
                    shareButtons: [
                        { id: "facebook", label: "Share on Facebook", url: "https://www.facebook.com/sharer/sharer.php?u={{url}}" },
                        { id: "twitter", label: "Tweet", url: "https://twitter.com/intent/tweet?text={{text}}&url={{url}}" },
                        { id: "pinterest", label: "Pin it", url: "http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}" },
                        { id: "download", label: "Download image", url: "{{raw_image_url}}", download: !0 },
                    ],
                    getImageURLForShare: function () {
                        return n.currItem.src || "";
                    },
                    getPageURLForShare: function () {
                        return window.location.href;
                    },
                    getTextForShare: function () {
                        return n.currItem.title || "";
                    },
                    indexIndicatorSep: " / ",
                },
                z = function () {
                    for (var e, t, i, n, s = "", a = 0; a < T.shareButtons.length; a++)
                        (e = T.shareButtons[a]),
                            (t = T.getImageURLForShare(e)),
                            (i = T.getPageURLForShare(e)),
                            (n = T.getTextForShare(e)),
                            (s +=
                                '<a href="' +
                                e.url.replace("{{url}}", encodeURIComponent(i)).replace("{{image_url}}", encodeURIComponent(t)).replace("{{raw_image_url}}", t).replace("{{text}}", encodeURIComponent(n)) +
                                '" target="_blank" class="pswp__share--' +
                                e.id +
                                '"' +
                                (e.download ? "download" : "") +
                                ">" +
                                e.label +
                                "</a>"),
                        T.parseShareButtonOut && (s = T.parseShareButtonOut(e, s));
                    (w.children[0].innerHTML = s), (w.children[0].onclick = o);
                },
                L = 0,
                W = function () {
                    clearTimeout(D), (L = 0), b && M.setIdle(!1);
                },
                N = function (e) {
                    x !== e && (t(k, "preloader--active", !e), (x = e));
                },
                Y = [
                    {
                        name: "caption",
                        option: "captionEl",
                        onInit: function (e) {
                            f = e;
                        },
                    },
                    {
                        name: "share-modal",
                        option: "shareEl",
                        onInit: function (e) {
                            w = e;
                        },
                        onTap: function () {
                            a();
                        },
                    },
                    {
                        name: "button--share",
                        option: "shareEl",
                        onInit: function (e) {
                            g = e;
                        },
                        onTap: function () {
                            a();
                        },
                    },
                    { name: "button--zoom", option: "zoomEl", onTap: n.toggleDesktopZoom },
                    {
                        name: "counter",
                        option: "counterEl",
                        onInit: function (e) {
                            v = e;
                        },
                    },
                    { name: "button--close", option: "closeEl", onTap: n.close },
                    { name: "button--arrow--left", option: "arrowEl", onTap: n.prev },
                    { name: "button--arrow--right", option: "arrowEl", onTap: n.next },
                    {
                        name: "button--fs",
                        option: "fullscreenEl",
                        onTap: function () {
                            h.isFullscreen() ? h.exit() : h.enter();
                        },
                    },
                    {
                        name: "preloader",
                        option: "preloaderEl",
                        onInit: function (e) {
                            k = e;
                        },
                    },
                ];
            (M.init = function () {
                var t;
                r.extend(n.options, A, !0),
                    (T = n.options),
                    (p = r.getChildByClass(n.scrollWrap, "pswp__ui")),
                    (_ = n.listen)("onVerticalDrag", function (e) {
                        I && e < 0.95 ? M.hideControls() : !I && 0.95 <= e && M.showControls();
                    }),
                    _("onPinchClose", function (e) {
                        I && e < 0.9 ? (M.hideControls(), (t = !0)) : t && !I && 0.9 < e && M.showControls();
                    }),
                    _("zoomGestureEnded", function () {
                        (t = !1) && !I && M.showControls();
                    }),
                    _("beforeChange", M.update),
                    _("doubleTap", function (e) {
                        var t = n.currItem.initialZoomLevel;
                        n.getZoomLevel() !== t ? n.zoomTo(t, e, 333) : n.zoomTo(T.getDoubleTapZoom(!1, n.currItem), e, 333);
                    }),
                    _("preventDragEvent", function (e, t, i) {
                        var n = e.target || e.srcElement;
                        n && n.className && -1 < e.type.indexOf("mouse") && (0 < n.className.indexOf("__caption") || /(SMALL|STRONG|EM)/i.test(n.tagName)) && (i.prevent = !1);
                    }),
                    _("bindEvents", function () {
                        r.bind(p, "pswpTap click", e), r.bind(n.scrollWrap, "pswpTap", M.onGlobalTap), n.likelyTouchDevice || r.bind(n.scrollWrap, "mouseover", M.onMouseOver);
                    }),
                    _("unbindEvents", function () {
                        P || a(),
                        E && clearInterval(E),
                            r.unbind(document, "mouseout", d),
                            r.unbind(document, "mousemove", W),
                            r.unbind(p, "pswpTap click", e),
                            r.unbind(n.scrollWrap, "pswpTap", M.onGlobalTap),
                            r.unbind(n.scrollWrap, "mouseover", M.onMouseOver),
                        h && (r.unbind(document, h.eventK, M.updateFullscreen), h.isFullscreen() && ((T.hideAnimationDuration = 0), h.exit()), (h = null));
                    }),
                    _("destroy", function () {
                        T.captionEl && (m && p.removeChild(m), r.removeClass(f, "pswp__caption--empty")), w && (w.children[0].onclick = null), r.removeClass(p, "pswp__ui--over-close"), r.addClass(p, "pswp__ui--hidden"), M.setIdle(!1);
                    }),
                T.showAnimationDuration || r.removeClass(p, "pswp__ui--hidden"),
                    _("initialZoomIn", function () {
                        T.showAnimationDuration && r.removeClass(p, "pswp__ui--hidden");
                    }),
                    _("initialZoomOut", function () {
                        r.addClass(p, "pswp__ui--hidden");
                    }),
                    _("parseVerticalMargin", c),
                    u(),
                T.shareEl && g && w && (P = !0),
                    i(),
                T.timeToIdle &&
                _("mouseUsed", function () {
                    r.bind(document, "mousemove", W),
                        r.bind(document, "mouseout", d),
                        (E = setInterval(function () {
                            2 === ++L && M.setIdle(!0);
                        }, T.timeToIdle / 2));
                }),
                T.fullscreenEl && ((h = h || M.getFullscreenAPI()) ? (r.bind(document, h.eventK, M.updateFullscreen), M.updateFullscreen(), r.addClass(n.template, "pswp--supports-fs")) : r.removeClass(n.template, "pswp--supports-fs")),
                T.preloaderEl &&
                (N(!0),
                    _("beforeChange", function () {
                        clearTimeout(C),
                            (C = setTimeout(function () {
                                n.currItem && n.currItem.loading ? (n.allowProgressiveImg() && (!n.currItem.img || n.currItem.img.naturalWidth)) || N(!1) : N(!0);
                            }, T.loadingIndicatorDelay));
                    }),
                    _("imageLoadComplete", function (e, t) {
                        n.currItem === t && N(!0);
                    }));
            }),
                (M.setIdle = function (e) {
                    t(p, "ui--idle", (b = e));
                }),
                (M.update = function () {
                    (O = !(!I || !n.currItem) && (M.updateIndexIndicator(), T.captionEl && (T.addCaptionHTMLFn(n.currItem, f), t(f, "caption--empty", !n.currItem.title)), !0)), P || a(), i();
                }),
                (M.updateFullscreen = function (e) {
                    e &&
                    setTimeout(function () {
                        n.setScrollOffset(0, r.getScrollY());
                    }, 50),
                        r[(h.isFullscreen() ? "add" : "remove") + "Class"](n.template, "pswp--fs");
                }),
                (M.updateIndexIndicator = function () {
                    T.counterEl && (v.innerHTML = n.getCurrentIndex() + 1 + T.indexIndicatorSep + T.getNumItemsFn());
                }),
                (M.onGlobalTap = function (e) {
                    var t = (e = e || window.event).target || e.srcElement;
                    if (!$)
                        if (e.detail && "mouse" === e.detail.pointerType)
                            l(t) ? n.close() : r.hasClass(t, "pswp__img") && (1 === n.getZoomLevel() && n.getZoomLevel() <= n.currItem.fitRatio ? T.clickToCloseNonZoomable && n.close() : n.toggleDesktopZoom(e.detail.releasePoint));
                        else if ((T.tapToToggleControls && (I ? M.hideControls() : M.showControls()), T.tapToClose && (r.hasClass(t, "pswp__img") || l(t)))) return void n.close();
                }),
                (M.onMouseOver = function (e) {
                    e = (e = e || window.event).target || e.srcElement;
                    t(p, "ui--over-close", l(e));
                }),
                (M.hideControls = function () {
                    r.addClass(p, "pswp__ui--hidden"), (I = !1);
                }),
                (M.showControls = function () {
                    (I = !0), O || M.update(), r.removeClass(p, "pswp__ui--hidden");
                }),
                (M.supportsFullscreen = function () {
                    var e = document;
                    return !!(e.exitFullscreen || e.mozCancelFullScreen || e.webkitExitFullscreen || e.msExitFullscreen);
                }),
                (M.getFullscreenAPI = function () {
                    var e,
                        t = document.documentElement,
                        i = "fullscreenchange";
                    return (
                        t.requestFullscreen
                            ? (e = { enterK: "requestFullscreen", exitK: "exitFullscreen", elementK: "fullscreenElement", eventK: i })
                            : t.mozRequestFullScreen
                                ? (e = { enterK: "mozRequestFullScreen", exitK: "mozCancelFullScreen", elementK: "mozFullScreenElement", eventK: "moz" + i })
                                : t.webkitRequestFullscreen
                                    ? (e = { enterK: "webkitRequestFullscreen", exitK: "webkitExitFullscreen", elementK: "webkitFullscreenElement", eventK: "webkit" + i })
                                    : t.msRequestFullscreen && (e = { enterK: "msRequestFullscreen", exitK: "msExitFullscreen", elementK: "msFullscreenElement", eventK: "MSFullscreenChange" }),
                        e &&
                        ((e.enter = function () {
                            return (y = T.closeOnScroll), (T.closeOnScroll = !1), "webkitRequestFullscreen" !== this.enterK ? n.template[this.enterK]() : void n.template[this.enterK](Element.ALLOW_KEYBOARD_INPUT);
                        }),
                            (e.exit = function () {
                                return (T.closeOnScroll = y), document[this.exitK]();
                            }),
                            (e.isFullscreen = function () {
                                return document[this.elementK];
                            })),
                            e
                    );
                });
        };
    }),
    (function (O, h) {
        "use strict";
        function o(p, f, m, e, t) {
            function i() {
                var s, a, o, r;
                (k = 1 < O.devicePixelRatio),
                    (m = n(m)),
                0 <= f.delay &&
                setTimeout(function () {
                    l(!0);
                }, f.delay),
                (f.delay < 0 || f.combined) &&
                ((e.e =
                    ((s = f.throttle),
                        (a = function (e) {
                            "resize" === e.type && (b = _ = -1), l(e.all);
                        }),
                        (r = 0),
                        function (e, t) {
                            function i() {
                                (r = +new Date()), a.call(p, e);
                            }
                            var n = +new Date() - r;
                            o && clearTimeout(o), s < n || !f.enableThrottle || t ? i() : (o = setTimeout(i, s - n));
                        })),
                    (e.a = function (e) {
                        (e = n(e)), m.push.apply(m, e);
                    }),
                    (e.g = function () {
                        return (m = I(m).filter(function () {
                            return !I(this).data(f.loadedName);
                        }));
                    }),
                    (e.f = function (e) {
                        for (var t = 0; t < e.length; t++) {
                            var i = m.filter(function () {
                                return this === e[t];
                            });
                            i.length && l(!1, i);
                        }
                    }),
                    l(),
                    I(f.appendScroll).on("scroll." + t + " resize." + t, e.e));
            }
            function n(e) {
                for (
                    var t = f.defaultImage,
                        i = f.placeholder,
                        n = f.imageBase,
                        s = f.srcsetAttribute,
                        a = f.loaderAttribute,
                        o = f._f || {},
                        r = 0,
                        l = (e = I(e)
                            .filter(function () {
                                var e = I(this),
                                    t = v(this);
                                return !e.data(f.handledName) && (e.attr(f.attribute) || e.attr(s) || e.attr(a) || o[t] !== h);
                            })
                            .data("plugin_" + f.name, p)).length;
                    r < l;
                    r++
                ) {
                    var d = I(e[r]),
                        c = v(e[r]),
                        u = d.attr(f.imageBaseAttribute) || n;
                    c === T &&
                    u &&
                    d.attr(s) &&
                    d.attr(
                        s,
                        (function (e, t) {
                            if (t) {
                                var i = e.split(",");
                                e = "";
                                for (var n = 0, s = i.length; n < s; n++) e += t + i[n].trim() + (n !== s - 1 ? "," : "");
                            }
                            return e;
                        })(d.attr(s), u)
                    ),
                    o[c] === h || d.attr(a) || d.attr(a, o[c]),
                        c === T && t && !d.attr($) ? d.attr($, t) : c === T || !i || (d.css(M) && "none" !== d.css(M)) || d.css(M, "url('" + i + "')");
                }
                return e;
            }
            function l(e, t) {
                if (!m.length) return f.autoDestroy && p.destroy(), 0;
                for (var i, n, s, a, o, r = t || m, l = !1, d = f.imageBase || "", c = f.srcsetAttribute, u = f.handledName, h = 0; h < r.length; h++)
                    (e ||
                        t ||
                        ((n = r[h]),
                            (s = o = a = s = void 0),
                            (s = n.getBoundingClientRect()),
                            (a = f.scrollDirection),
                            (o = f.threshold),
                            (n = (0 <= _ ? _ : (_ = I(O).height())) + o > s.top && -o < s.bottom),
                            (s = (0 <= b ? b : (b = I(O).width())) + o > s.left && -o < s.right),
                            "vertical" === a ? n : ("horizontal" === a || n) && s)) &&
                    ((i = I(r[h])),
                        (o = v(r[h])),
                        (a = i.attr(f.attribute)),
                        (n = i.attr(f.imageBaseAttribute) || d),
                        (s = i.attr(f.loaderAttribute)),
                    i.data(u) ||
                    (f.visibleOnly && !i.is(":visible")) ||
                    !(((a || i.attr(c)) && ((o === T && (n + a !== i.attr($) || i.attr(c) !== i.attr(E))) || (o !== T && n + a !== i.css(M)))) || s) ||
                    ((l = !0),
                        i.data(u, !0),
                        (function (t, e, i, n) {
                            ++y;
                            var s = function () {
                                w("onError", t), g(), (s = I.noop);
                            };
                            w("beforeLoad", t);
                            var a,
                                o,
                                r = f.attribute,
                                l = f.srcsetAttribute,
                                d = f.sizesAttribute,
                                c = f.retinaAttribute,
                                u = f.removeAttribute,
                                h = f.loadedName,
                                p = t.attr(c);
                            n
                                ? ((a = function () {
                                    u && t.removeAttr(f.loaderAttribute), t.data(h, !0), w(x, t), setTimeout(g, 1), (a = I.noop);
                                }),
                                    t.off(S).one(S, s).one(C, a),
                                w(n, t, function (e) {
                                    e ? (t.off(C), a()) : (t.off(S), s());
                                }) || t.trigger(S))
                                : ((o = I(new Image())).one(S, s).one(C, function () {
                                    t.hide(),
                                        e === T ? t.attr(D, o.attr(D)).attr(E, o.attr(E)).attr($, o.attr($)) : t.css(M, "url('" + o.attr($) + "')"),
                                        t[f.effect](f.effectTime),
                                    u && (t.removeAttr(r + " " + l + " " + c + " " + f.imageBaseAttribute), d !== D && t.removeAttr(d)),
                                        t.data(h, !0),
                                        w(x, t),
                                        o.remove(),
                                        g();
                                }),
                                    (p = (k && p ? p : t.attr(r)) || ""),
                                    o
                                        .attr(D, t.attr(d))
                                        .attr(E, t.attr(l))
                                        .attr($, p ? i + p : null),
                                o.complete && o.trigger(C));
                        })(i, o, n, s)));
                l &&
                (m = I(m).filter(function () {
                    return !I(this).data(u);
                }));
            }
            function v(e) {
                return e.tagName.toLowerCase();
            }
            function g() {
                --y, m.length || y || w("onFinishedAll");
            }
            function w(e) {
                return (e = f[e]) && (e.apply(p, [].slice.call(arguments, 1)), 1);
            }
            var y = 0,
                b = -1,
                _ = -1,
                k = !1,
                x = "afterLoad",
                C = "load",
                S = "error",
                T = "img",
                $ = "src",
                E = "srcset",
                D = "sizes",
                M = "background-image";
            "event" === f.bind || s ? i() : I(O).on(C + "." + t, i);
        }
        function d(e, t) {
            var i = this,
                n = I.extend({}, i.config, t),
                s = {},
                a = n.name + "-" + ++r;
            return (
                (i.config = function (e, t) {
                    return t === h ? n[e] : ((n[e] = t), i);
                }),
                    (i.addItems = function (e) {
                        return s.a && s.a("string" === I.type(e) ? I(e) : e), i;
                    }),
                    (i.getItems = function () {
                        return s.g ? s.g() : {};
                    }),
                    (i.update = function (e) {
                        return s.e && s.e({}, !e), i;
                    }),
                    (i.force = function (e) {
                        return s.f && s.f("string" === I.type(e) ? I(e) : e), i;
                    }),
                    (i.loadAll = function () {
                        return s.e && s.e({ all: !0 }, !0), i;
                    }),
                    (i.destroy = function () {
                        return I(n.appendScroll).off("." + a, s.e), I(O).off("." + a), (s = {}), h;
                    }),
                    o(i, n, e, s, a),
                    n.chainable ? e : i
            );
        }
        var I = O.jQuery || O.Zepto,
            r = 0,
            s = !1;
        (I.fn.Lazy = I.fn.lazy = function (e) {
            return new d(this, e);
        }),
            (I.Lazy = I.lazy = function (e, t, i) {
                if ((I.isFunction(t) && ((i = t), (t = [])), I.isFunction(i))) {
                    (e = I.isArray(e) ? e : [e]), (t = I.isArray(t) ? t : [t]);
                    for (var n = d.prototype.config, s = n._f || (n._f = {}), a = 0, o = e.length; a < o; a++) (n[e[a]] !== h && !I.isFunction(n[e[a]])) || (n[e[a]] = i);
                    for (var r = 0, l = t.length; r < l; r++) s[t[r]] = e[0];
                }
            }),
            (d.prototype.config = {
                name: "lazy",
                chainable: !0,
                autoDestroy: !0,
                bind: "load",
                threshold: 500,
                visibleOnly: !1,
                appendScroll: O,
                scrollDirection: "both",
                imageBase: null,
                defaultImage: "data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==",
                placeholder: null,
                delay: -1,
                combined: !1,
                attribute: "data-src",
                srcsetAttribute: "data-srcset",
                sizesAttribute: "data-sizes",
                retinaAttribute: "data-retina",
                loaderAttribute: "data-loader",
                imageBaseAttribute: "data-imagebase",
                removeAttribute: !0,
                handledName: "handled",
                loadedName: "loaded",
                effect: "show",
                effectTime: 0,
                enableThrottle: !0,
                throttle: 250,
                beforeLoad: h,
                afterLoad: h,
                onError: h,
                onFinishedAll: h,
            }),
            I(O).on("load", function () {
                s = !0;
            });
    })(window),
    (function (a) {
        function i(t, i, n, e) {
            var s;
            ("POST" !== (e = e ? e.toUpperCase() : "GET") && "PUT" !== e) || !t.config("ajaxCreateData") || (s = t.config("ajaxCreateData").apply(t, [i])),
                a.ajax({
                    url: i.attr("data-src"),
                    type: "POST" === e || "PUT" === e ? e : "GET",
                    data: s,
                    dataType: i.attr("data-type") || "html",
                    success: function (e) {
                        i.html(e), n(!0), t.config("removeAttribute") && i.removeAttr("data-src data-method data-type");
                    },
                    error: function () {
                        n(!1);
                    },
                });
        }
        a.lazy("ajax", function (e, t) {
            i(this, e, t, e.attr("data-method"));
        }),
            a.lazy("get", function (e, t) {
                i(this, e, t, "GET");
            }),
            a.lazy("post", function (e, t) {
                i(this, e, t, "POST");
            }),
            a.lazy("put", function (e, t) {
                i(this, e, t, "PUT");
            });
    })(window.jQuery || window.Zepto),
    (function (r) {
        r.lazy(["av", "audio", "video"], ["audio", "video"], function (i, e) {
            var t,
                n,
                s,
                a,
                o = i[0].tagName.toLowerCase();
            "audio" === o || "video" === o
                ? ((t = i.find("data-src")),
                    (n = i.find("data-track")),
                    (s = 0),
                    (a = function () {
                        ++s === t.length && e(!1);
                    }),
                    (o = function () {
                        var e = r(this),
                            t = e[0].tagName.toLowerCase(),
                            i = e.prop("attributes"),
                            n = r("data-src" === t ? "<source>" : "<track>");
                        "data-src" === t && n.one("error", a),
                            r.each(i, function (e, t) {
                                n.attr(t.name, t.value);
                            }),
                            e.replaceWith(n);
                    }),
                    i
                        .one("loadedmetadata", function () {
                            e(!0);
                        })
                        .off("load error")
                        .attr("poster", i.attr("data-poster")),
                    t.length
                        ? t.each(o)
                        : i.attr("data-src")
                            ? (r.each(i.attr("data-src").split(","), function (e, t) {
                                t = t.split("|");
                                i.append(r("<source>").one("error", a).attr({ src: t[0].trim(), type: t[1].trim() }));
                            }),
                            this.config("removeAttribute") && i.removeAttr("data-src"))
                            : e(!1),
                n.length && n.each(o))
                : e(!1);
        });
    })(window.jQuery || window.Zepto),
    (function (s) {
        s.lazy(["frame", "iframe"], "iframe", function (t, e) {
            var i,
                n = this;
            "iframe" === t[0].tagName.toLowerCase()
                ? "true" !== (i = t.attr("data-error-detect")) && "1" !== i
                    ? (t.attr("src", t.attr("data-src")), n.config("removeAttribute") && t.removeAttr("data-src data-error-detect"))
                    : s.ajax({
                        url: t.attr("data-src"),
                        dataType: "html",
                        crossDomain: !0,
                        xhrFields: { withCredentials: !0 },
                        success: function (e) {
                            t.html(e).attr("src", t.attr("data-src")), n.config("removeAttribute") && t.removeAttr("data-src data-error-detect");
                        },
                        error: function () {
                            e(!1);
                        },
                    })
                : e(!1);
        });
    })(window.jQuery || window.Zepto),
    (function (e) {
        e.lazy("noop", function () {}),
            e.lazy("noop-success", function (e, t) {
                t(!0);
            }),
            e.lazy("noop-error", function (e, t) {
                t(!1);
            });
    })(window.jQuery || window.Zepto),
    (function (a) {
        function o(e, t, i) {
            var n = e.prop("attributes"),
                s = a("<" + t + ">");
            return (
                a.each(n, function (e, t) {
                    ("srcset" !== t.name && t.name !== d) || (t.value = l(t.value, i)), s.attr(t.name, t.value);
                }),
                    e.replaceWith(s),
                    s
            );
        }
        function r(e, t, i) {
            t = a("<img>")
                .one("load", function () {
                    i(!0);
                })
                .one("error", function () {
                    i(!1);
                })
                .appendTo(e)
                .attr("src", t);
            t.complete && t.load();
        }
        function l(e, t) {
            if (t) {
                var i = e.split(",");
                e = "";
                for (var n = 0, s = i.length; n < s; n++) e += t + i[n].trim() + (n !== s - 1 ? "," : "");
            }
            return e;
        }
        var d = "data-src";
        a.lazy(["pic", "picture"], ["picture"], function (e, t) {
            var i, n, s;
            "picture" === e[0].tagName.toLowerCase()
                ? ((i = e.find(d)),
                    (n = e.find("data-img")),
                    (s = this.config("imageBase") || ""),
                    i.length
                        ? (i.each(function () {
                            o(a(this), "source", s);
                        }),
                            1 === n.length
                                ? ((n = o(n, "img", s))
                                    .on("load", function () {
                                        t(!0);
                                    })
                                    .on("error", function () {
                                        t(!1);
                                    }),
                                    n.attr("src", n.attr(d)),
                                this.config("removeAttribute") && n.removeAttr(d))
                                : e.attr(d)
                                    ? (r(e, s + e.attr(d), t), this.config("removeAttribute") && e.removeAttr(d))
                                    : t(!1))
                        : e.attr("data-srcset")
                            ? (a("<source>")
                                .attr({ media: e.attr("data-media"), sizes: e.attr("data-sizes"), type: e.attr("data-type"), srcset: l(e.attr("data-srcset"), s) })
                                .appendTo(e),
                                r(e, s + e.attr(d), t),
                            this.config("removeAttribute") && e.removeAttr(d + " data-srcset data-media data-sizes data-type"))
                            : t(!1))
                : t(!1);
        });
    })(window.jQuery || window.Zepto),
    (window.jQuery || window.Zepto).lazy(["js", "javascript", "script"], "script", function (e, t) {
        "script" === e[0].tagName.toLowerCase() ? (e.attr("src", e.attr("data-src")), this.config("removeAttribute") && e.removeAttr("data-src")) : t(!1);
    }),
    (window.jQuery || window.Zepto).lazy("vimeo", function (e, t) {
        "iframe" === e[0].tagName.toLowerCase() ? (e.attr("src", "https://player.vimeo.com/video/" + e.attr("data-src")), this.config("removeAttribute") && e.removeAttr("data-src")) : t(!1);
    }),
    (window.jQuery || window.Zepto).lazy(["yt", "youtube"], function (e, t) {
        "iframe" === e[0].tagName.toLowerCase() ? (e.attr("src", "https://www.youtube.com/embed/" + e.attr("data-src") + "?rel=0&amp;showinfo=0"), this.config("removeAttribute") && e.removeAttr("data-src")) : t(!1);
    });
