export default function helper() {
  const currencyFormat = (n) => {
    return n.toLocaleString().replace(/\d(?=(\d{3})+\.)/g, "$&,")
  }

  const round = (n, precision) => {
    var prec = Math.pow(10, precision)
    return Math.round(n * prec) / prec
  }

  const stockFormat = (value) => {
    let abbrev = ["k", "m", "b"]
    let base = Math.floor(Math.log(Math.abs(value)) / Math.log(1000))
    let suffix = abbrev[Math.min(2, base - 1)]
    base = abbrev.indexOf(suffix) + 1
    return suffix ? round(value / Math.pow(1000, base), 2)+suffix : ""+value }

  return { currencyFormat, stockFormat }
}
