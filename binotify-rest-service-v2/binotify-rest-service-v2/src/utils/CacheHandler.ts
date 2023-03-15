import cache from "memory-cache";

class CacheHandler {
  private readonly EXPIRATION_TIME = 300;

  public put(key: any, value: unknown) {
    return cache.put(key, value, this.EXPIRATION_TIME);
  }

  public get(key: any) {
    return cache.get(key);
  }

  public async handle(key: any, callback: () => any) {
    console.log("CHECK FOR CACHE WITH KEY " + key);
    const cached = this.get(key);
    if (cached) {
      console.log("CACHE FOUND WITH RESULT " + JSON.stringify(cached));
      return cached;
    }
    console.log("CACHE NOT FOUND, CALLING CALLBACK");

    const result = await callback();
    this.put(key, result);

    console.log("CACHE PUT WITH RESULT " + JSON.stringify(result));

    return result;
  }
}

export default new CacheHandler();