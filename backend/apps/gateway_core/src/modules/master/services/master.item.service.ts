import { IAccountCreatedBy } from '@gateway_core/account/interface/account.create_by'
import {
  MasterItemAddDTO,
  MasterItemEditDTO,
} from '@gateway_core/master/dto/master.item'
import { IMasterItem } from '@interfaces/master.item'
import { InjectQueue } from '@nestjs/bullmq'
import { HttpStatus, Inject, Injectable } from '@nestjs/common'
import { ConfigService } from '@nestjs/config'
import { InjectModel } from '@nestjs/mongoose'
import { MasterItem, MasterItemDocument } from '@schemas/master/master.item'
import { GlobalResponse } from '@utility/dto/response'
import { modCodes } from '@utility/modules'
import prime_datatable from '@utility/prime'
import { TimeManagement } from '@utility/time'
import { Queue } from 'bullmq'
import { isJSON } from 'class-validator'
import { Model } from 'mongoose'

@Injectable()
export class MasterItemService {
  constructor(
    @Inject(ConfigService) private readonly configService: ConfigService,

    @InjectModel(MasterItem.name, 'primary')
    private masterItemModel: Model<MasterItemDocument>,

    @InjectQueue('master_data') private masterDataQueue: Queue
  ) {}

  async all(parameter: any): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_LIST',
      transaction_id: null,
    } satisfies GlobalResponse
    if (isJSON(parameter)) {
      const parsedData = JSON.parse(parameter)
      return await prime_datatable(parsedData, this.masterItemModel).then(
        (result) => {
          response.payload = result.payload
          response.message = 'Data query success'
          return response
        }
      )
    } else {
      response.statusCode = {
        defaultCode: HttpStatus.BAD_REQUEST,
        customCode: modCodes.Global.failed,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.message = 'filters is not a valid json'
      throw new Error(JSON.stringify(response))
    }
  }

  async detail(id: string): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_GET',
      transaction_id: id,
    } satisfies GlobalResponse

    try {
      return await this.masterItemModel.findOne({ id: id }).then((result) => {
        response.payload = result
        response.message = 'Master item detail fetch successfully'
        return response
      })
    } catch (error) {
      response.message = `Master item detail failed to fetch`
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }

  async find(term: any): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_GET',
      transaction_id: '',
    } satisfies GlobalResponse

    try {
      return await this.masterItemModel.findOne(term).then((result) => {
        response.payload = result
        response.message = 'Master item detail fetch successfully'
        return response
      })
    } catch (error) {
      response.message = `Master item detail failed to fetch`
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }

  async bulk(bulkData = []) {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_IMPORT',
      transaction_id: '',
    } satisfies GlobalResponse

    try {
      if (bulkData.length > 0) {
        const prepareBulk = await Promise.all(
          bulkData.map(async (data) => {
            let prepareData = await this.find({
              $and: [{ code: data.code }],
            }).then((r) => r)['payload']
            prepareData = !prepareData ? { code: '' } : prepareData
            // eslint-disable-next-line @typescript-eslint/no-unused-vars
            const { code, ...dataRes } = prepareData
            return !prepareData ? data : dataRes
          })
        )
        return await this.masterItemModel
          .bulkSave(prepareBulk, { ordered: false })
          .then(() => {
            response.message = 'Data imported successfully'
            return response
          })
      } else {
        response.message = `Data to import is empty`
        response.statusCode = {
          ...modCodes[this.constructor.name].error.databaseError,
          classCode: modCodes[this.constructor.name].defaultCode,
        }
        response.payload = bulkData
        throw new Error(JSON.stringify(response))
      }
    } catch (error) {
      response.message = error.message
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error.stack
      throw new Error(JSON.stringify(response))
    }
  }

  async import(data: any, account: IAccountCreatedBy): Promise<GlobalResponse> {
    return {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: await this.masterDataQueue.add(
        'master_item',
        {
          account: account,
          file: data.file,
        },
        { removeOnComplete: true }
      )['id'],
      transaction_classify: 'MASTER_ITEM_IMPORT',
      transaction_id: null,
    } satisfies GlobalResponse
  }

  async add(
    data: MasterItemAddDTO,
    account: IAccountCreatedBy
  ): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_ADD',
      transaction_id: null,
    } satisfies GlobalResponse

    if (!data.code) {
      data.code = `${modCodes[this.constructor.name].defaultCode}-${new Date().getTime()}`
    }

    try {
      return await this.masterItemModel
        .create({
          ...data,
          created_by: account,
        })
        .then((result) => {
          response.message = 'Master item created successfully'
          response.transaction_id = result._id
          response.payload = result
          return response
        })
    } catch (error) {
      response.message = `Master item failed to create`
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }

  async edit(data: MasterItemEditDTO, id: string): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_EDIT',
      transaction_id: null,
    } satisfies GlobalResponse

    try {
      return await this.masterItemModel
        .findOneAndUpdate(
          {
            id: id,
            __v: data.__v,
          },
          {
            code: data.code,
            name: data.name,
            brand: data.brand,
            category: data.category,
            unit_conversion: data.unit_conversion,
            properties: data.properties,
            remark: data.remark,
          }
        )
        .then((result) => {
          response.message = 'Master item updated successfully'
          response.payload = result
          return response
        })
    } catch (error) {
      response.message = `Master item failed to update`
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }

  async upsert(term: any, account: IAccountCreatedBy): Promise<IMasterItem> {
    return await this.masterItemModel
      .findOne({
        name: term.name,
      })
      .then(async (result) => {
        if (result) {
          return result
        } else {
          return await this.add(
            {
              name: term.name,
              configuration: {
                allow_sell: true,
              },
              properties: [],
              category: term.category,
              brand: term.brand,
              storing: [],
              unit_conversion: term.unit_conversion,
              remark: 'Auto Generated Item',
            },
            account
          ).then((addResult) => {
            return addResult.payload as IMasterItem
          })
        }
      })
  }

  async delete(id: string): Promise<GlobalResponse> {
    const response = {
      statusCode: {
        defaultCode: HttpStatus.OK,
        customCode: modCodes.Global.success,
        classCode: modCodes[this.constructor.name].defaultCode,
      },
      message: '',
      payload: {},
      transaction_classify: 'MASTER_ITEM_DELETE',
      transaction_id: null,
    } satisfies GlobalResponse

    try {
      return await this.masterItemModel
        .findOneAndUpdate(
          {
            id: id,
          },
          {
            deleted_at: new TimeManagement().getTimezone(
              await this.configService.get<string>('application.timezone')
            ),
          }
        )
        .then(async () => {
          response.message = 'Master item deleted successfully'
          return response
        })
    } catch (error) {
      response.message = 'Master item failed to delete'
      response.statusCode = {
        ...modCodes[this.constructor.name].error.databaseError,
        classCode: modCodes[this.constructor.name].defaultCode,
      }
      response.payload = error
      throw new Error(JSON.stringify(response))
    }
  }
}
