function encode(text) {
    return text
      .replace(/&/g, "#amp;")
      .replace(/"/g, "#quot;")
      .replace(/\+/g, "#plus;")
      .replace(/'/g, "#039;");
}