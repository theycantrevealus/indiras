import { CMasterQueue } from '@gateway_core/master/dto/master.queue'
import { ApiProperty } from '@nestjs/swagger'
import { IsNotEmpty } from 'class-validator'

import { IMasterQueue } from '../../../../../../interfaces/master.queue'

export class QueueAddDTO {
  @ApiProperty({
    type: CMasterQueue,
  })
  @IsNotEmpty()
  machine: IMasterQueue
}
