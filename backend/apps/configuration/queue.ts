import {
  BullRootModuleOptions,
  SharedBullConfigurationFactory,
} from '@nestjs/bullmq'
import { Inject, Injectable } from '@nestjs/common'
import { ConfigModule, ConfigService } from '@nestjs/config'
import { environmentIdentifier } from '@utility/environtment'
import * as dotenv from 'dotenv'

dotenv.config({
  path: environmentIdentifier,
})

export const QueueProcess = () => ({
  queue: {
    host: process.env.QUEUE_HOST,
    port: process.env.QUEUE_PORT,
    items: process.env.QUEUE_ITEM,
  },
})

export const QueueMasterData = {
  name: process.env.QUEUE_DATA_MASTER,
  imports: [ConfigModule],
  inject: [ConfigService],
  useFactory: async (configService: ConfigService) => ({
    connection: {
      host: configService.get<string>('queue.host'),
      port: configService.get<number>('queue.port'),
    },
  }),
}

@Injectable()
export class BullConfigService implements SharedBullConfigurationFactory {
  constructor(
    @Inject(ConfigService) private readonly configService: ConfigService
  ) {}

  createSharedConfiguration():
    | BullRootModuleOptions
    | Promise<BullRootModuleOptions> {
    return {
      connection: {
        host: this.configService.get<string>('queue.host'),
        port: this.configService.get<number>('queue.port'),
      },
    }
  }
}
