import { Controller } from '@nestjs/common'

import { ImportService } from './import.service'

@Controller()
export class ImportController {
  constructor(private readonly importService: ImportService) {}

  // @MessagePattern('master_item')
  // proceed(@Payload() payload) {
  //   return this.importService.proceed_import(payload.file, payload.account)
  // }
}
