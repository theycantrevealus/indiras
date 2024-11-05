import { createParamDecorator, ExecutionContext } from '@nestjs/common'
import { FastifyRequest, StorageMultipartFile } from '@utility/dto/file'

export const Files = createParamDecorator(
  async (
    _data: unknown,
    ctx: ExecutionContext
  ): Promise<null | Record<string, StorageMultipartFile[]>> => {
    const req = ctx.switchToHttp().getRequest() as FastifyRequest
    return req.storedFiles
  }
)

export interface MultipartFile {
  buffer: Buffer
  filename: string
  size: number
  mimetype: string
  fieldname: string
}
