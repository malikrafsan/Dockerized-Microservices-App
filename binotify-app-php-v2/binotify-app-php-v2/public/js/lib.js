class Lib {
  async promiseAjax(url, payload, asXML, method) {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();

      xhr.onload = () => {
        if (!asXML) {
          try {
            resolve(xhr.responseText);
          } catch (e) {
            reject(e);
          }
        } else {
          resolve(xhr.responseXML);
        }
      };

      xhr.onerror = () => {
        reject(new Error("Fetch error"));
      };

      const usedMethod = method || "GET";
      const params = new URLSearchParams(payload).toString();
      xhr.open(
        usedMethod,
        usedMethod !== "GET" ? url : payload ? `${url}?${params}` : url
      );
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      payload ? xhr.send(params) : xhr.send();
    });
  }

  async get(url, payload, asXML) {
    return await this.promiseAjax(url, payload, asXML, "GET");
  }

  async post(url, payload, asXML) {
    return await this.promiseAjax(url, payload, asXML, "POST");
  }

  async put(url, payload, asXML) {
    return await this.promiseAjax(url, payload, asXML, "PUT");
  }

  async delete(url, asXML) {
    return await this.promiseAjax(url, null, asXML, "DELETE");
  }

  debounce(func, timeout = 300) {
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => {
        func.apply(this, args);
      }, timeout);
    };
  }

  async uploadFile(file, url, asXML) {
    return new Promise((resolve, reject) => {
      const formData = new FormData();
      formData.append("file", file);

      const xhr = new XMLHttpRequest();
      xhr.open("POST", url, true);

      xhr.onload = () => {
        if (!asXML) {
          try {
            resolve(xhr.responseText);
          } catch (e) {
            reject(e);
          }
        } else {
          resolve(xhr.responseXML);
        }
      };

      xhr.onerror = () => {
        reject(new Error("Fetch error"));
      };

      xhr.send(formData);
    });
  }
}
