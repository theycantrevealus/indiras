import { ConsumerGeneralDataDTO } from '@utility/dto/consumer'

import { IMasterQueue } from '../../../interfaces/master.queue'

class ConsumerQueueDataDTO {
  machine: IMasterQueue
}

export class ConsumerQueueDTO extends ConsumerGeneralDataDTO {
  data: ConsumerQueueDataDTO
}
