var LZString = function() {
    function f(n, t) {
        if (!i[n]) {
            i[n] = {};
            for (var r = 0; r < n.length; r++) i[n][n.charAt(r)] = r
        }
        return i[n][t]
    }
    var t = String.fromCharCode,
        r = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
        u = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+-$",
        i = {},
        n = {
            compressToBase64: function(t) {
                if (t == null) return "";
                var i = n._compress(t, 6, function(n) {
                    return r.charAt(n)
                });
                switch (i.length % 4) {
                    default:
                        case 0:
                        return i;
                    case 1:
                            return i + "===";
                    case 2:
                            return i + "==";
                    case 3:
                            return i + "="
                }
            },
            decompressFromBase64: function(t) {
                return t == null ? "" : t == "" ? null : n._decompress(t.length, 32, function(n) {
                    return f(r, t.charAt(n))
                })
            },
            compressToUTF16: function(i) {
                return i == null ? "" : n._compress(i, 15, function(n) {
                    return t(n + 32)
                }) + " "
            },
            decompressFromUTF16: function(t) {
                return t == null ? "" : t == "" ? null : n._decompress(t.length, 16384, function(n) {
                    return t.charCodeAt(n) - 32
                })
            },
            compressToUint8Array: function(t) {
                for (var r = n.compress(t), u = new Uint8Array(r.length * 2), f, i = 0, e = r.length; i < e; i++) f = r.charCodeAt(i), u[i * 2] = f >>> 8, u[i * 2 + 1] = f % 256;
                return u
            },
            decompressFromUint8Array: function(i) {
                var u, r, e, f;
                if (i === null || i === undefined) return n.decompress(i);
                for (u = new Array(i.length / 2), r = 0, e = u.length; r < e; r++) u[r] = i[r * 2] * 256 + i[r * 2 + 1];
                return f = [], u.forEach(function(n) {
                    f.push(t(n))
                }), n.decompress(f.join(""))
            },
            compressToEncodedURIComponent: function(t) {
                return t == null ? "" : n._compress(t, 6, function(n) {
                    return u.charAt(n)
                })
            },
            decompressFromEncodedURIComponent: function(t) {
                return t == null ? "" : t == "" ? null : (t = t.replace(/ /g, "+"), n._decompress(t.length, 32, function(n) {
                    return f(u, t.charAt(n))
                }))
            },
            compress: function(i) {
                return n._compress(i, 16, function(n) {
                    return t(n)
                })
            },
            _compress: function(n, t, i) {
                if (n == null) return "";
                for (var e, f, l = {}, v = {}, a = "", y = "", o = "", c = 2, w = 3, s = 2, h = [], r = 0, u = 0, p = 0; p < n.length; p += 1)
                    if (a = n.charAt(p), Object.prototype.hasOwnProperty.call(l, a) || (l[a] = w++, v[a] = !0), y = o + a, Object.prototype.hasOwnProperty.call(l, y)) o = y;
                    else {
                        if (Object.prototype.hasOwnProperty.call(v, o)) {
                            if (o.charCodeAt(0) < 256) {
                                for (e = 0; e < s; e++) r = r << 1, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++;
                                for (f = o.charCodeAt(0), e = 0; e < 8; e++) r = r << 1 | f & 1, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++, f = f >> 1
                            } else {
                                for (f = 1, e = 0; e < s; e++) r = r << 1 | f, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++, f = 0;
                                for (f = o.charCodeAt(0), e = 0; e < 16; e++) r = r << 1 | f & 1, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++, f = f >> 1
                            }
                            c--;
                            c == 0 && (c = Math.pow(2, s), s++);
                            delete v[o]
                        } else
                            for (f = l[o], e = 0; e < s; e++) r = r << 1 | f & 1, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++, f = f >> 1;
                        c--;
                        c == 0 && (c = Math.pow(2, s), s++);
                        l[y] = w++;
                        o = String(a)
                    }
                if (o !== "") {
                    if (Object.prototype.hasOwnProperty.call(v, o)) {
                        if (o.charCodeAt(0) < 256) {
                            for (e = 0; e < s; e++) r = r << 1, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++;
                            for (f = o.charCodeAt(0), e = 0; e < 8; e++) r = r << 1 | f & 1, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++, f = f >> 1
                        } else {
                            for (f = 1, e = 0; e < s; e++) r = r << 1 | f, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++, f = 0;
                            for (f = o.charCodeAt(0), e = 0; e < 16; e++) r = r << 1 | f & 1, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++, f = f >> 1
                        }
                        c--;
                        c == 0 && (c = Math.pow(2, s), s++);
                        delete v[o]
                    } else
                        for (f = l[o], e = 0; e < s; e++) r = r << 1 | f & 1, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++, f = f >> 1;
                    c--;
                    c == 0 && (c = Math.pow(2, s), s++)
                }
                for (f = 2, e = 0; e < s; e++) r = r << 1 | f & 1, u == t - 1 ? (u = 0, h.push(i(r)), r = 0) : u++, f = f >> 1;
                for (;;)
                    if (r = r << 1, u == t - 1) {
                        h.push(i(r));
                        break
                    } else u++;
                return h.join("")
            },
            decompress: function(t) {
                return t == null ? "" : t == "" ? null : n._decompress(t.length, 32768, function(n) {
                    return t.charCodeAt(n)
                })
            },
            _decompress: function(n, i, r) {
                for (var c = [], k, l = 4, a = 4, v = 3, y = "", b = [], w, e, o, s, f, h, u = {
                        val: r(0),
                        position: i,
                        index: 1
                    }, p = 0; p < 3; p += 1) c[p] = p;
                for (e = 0, s = Math.pow(2, 2), f = 1; f != s;) o = u.val & u.position, u.position >>= 1, u.position == 0 && (u.position = i, u.val = r(u.index++)), e |= (o > 0 ? 1 : 0) * f, f <<= 1;
                switch (k = e) {
                    case 0:
                        for (e = 0, s = Math.pow(2, 8), f = 1; f != s;) o = u.val & u.position, u.position >>= 1, u.position == 0 && (u.position = i, u.val = r(u.index++)), e |= (o > 0 ? 1 : 0) * f, f <<= 1;
                        h = t(e);
                        break;
                    case 1:
                        for (e = 0, s = Math.pow(2, 16), f = 1; f != s;) o = u.val & u.position, u.position >>= 1, u.position == 0 && (u.position = i, u.val = r(u.index++)), e |= (o > 0 ? 1 : 0) * f, f <<= 1;
                        h = t(e);
                        break;
                    case 2:
                        return ""
                }
                for (c[3] = h, w = h, b.push(h);;) {
                    if (u.index > n) return "";
                    for (e = 0, s = Math.pow(2, v), f = 1; f != s;) o = u.val & u.position, u.position >>= 1, u.position == 0 && (u.position = i, u.val = r(u.index++)), e |= (o > 0 ? 1 : 0) * f, f <<= 1;
                    switch (h = e) {
                        case 0:
                            for (e = 0, s = Math.pow(2, 8), f = 1; f != s;) o = u.val & u.position, u.position >>= 1, u.position == 0 && (u.position = i, u.val = r(u.index++)), e |= (o > 0 ? 1 : 0) * f, f <<= 1;
                            c[a++] = t(e);
                            h = a - 1;
                            l--;
                            break;
                        case 1:
                            for (e = 0, s = Math.pow(2, 16), f = 1; f != s;) o = u.val & u.position, u.position >>= 1, u.position == 0 && (u.position = i, u.val = r(u.index++)), e |= (o > 0 ? 1 : 0) * f, f <<= 1;
                            c[a++] = t(e);
                            h = a - 1;
                            l--;
                            break;
                        case 2:
                            return b.join("")
                    }
                    if (l == 0 && (l = Math.pow(2, v), v++), c[h]) y = c[h];
                    else if (h === a) y = w + w.charAt(0);
                    else return null;
                    b.push(y);
                    c[a++] = w + y.charAt(0);
                    l--;
                    w = y;
                    l == 0 && (l = Math.pow(2, v), v++)
                }
            }
        };
    return n
}();
typeof define == "function" && define.amd ? define(function() {
    return LZString
}) : typeof module != "undefined" && module != null ? module.exports = LZString : typeof angular != "undefined" && angular != null && angular.module("LZString", []).factory("LZString", function() {
    return LZString
})