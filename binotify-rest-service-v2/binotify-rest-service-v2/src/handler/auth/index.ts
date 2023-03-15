import loginHandler from './login';
import registerHandler from './register';
import currentUserHandler from './current-user';

import { IAuthHandler, handlerType } from '../../interfaces';

class AuthHandler {
  loginHandler: handlerType;
  registerHandler: handlerType;
  currentUserHandler:  handlerType;

  constructor() {
    this.loginHandler = loginHandler;
    this.registerHandler = registerHandler;
    this.currentUserHandler = currentUserHandler;
  }
}

export default new AuthHandler() as IAuthHandler;