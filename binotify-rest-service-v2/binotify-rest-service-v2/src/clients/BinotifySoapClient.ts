import { SoapCaller } from '../utils'
import { ISubscription } from '../interfaces'

class BinotifySoapClient {
  private soapCaller: SoapCaller

  constructor(url: string) {
    this.soapCaller = new SoapCaller(url)
  }

  public async getSubscriptions() {
    return await this.soapCaller.call('getSubscriptions')
  }

  public async acceptSubscription(creatorId: number, subscriptionId: number) {
    const args = {
      arg0: creatorId,
      arg1: subscriptionId,
    }

    return await this.soapCaller.call('acceptSubscription', args)
  }

  public async rejectSubscription(creatorId: number, subscriptionId: number) {
    const args = {
      arg0: creatorId,
      arg1: subscriptionId,
    }

    return await this.soapCaller.call('rejectSubscription', args)
  }

  public async checkStatus(creatorId: string, subscriptionId: string) {
    const args = {
      arg0: creatorId,
      arg1: subscriptionId,
    }

    return this.soapCaller.call('checkStatus', args) as unknown as ISubscription
  }
}

const url = process.env.SOAP_URL;
export default new BinotifySoapClient(url ? url : "");

