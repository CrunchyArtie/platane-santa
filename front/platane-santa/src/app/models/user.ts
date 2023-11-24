import {Image, RawImageData} from "./image";

export interface RawUserData { id: number; email: string; name: string; created_at: string; updated_at: string, images: RawImageData[] };

export class User {
  public readonly id: number;
  public readonly email: string;
  public readonly name: string;
  public readonly created_at: Date;
  public readonly updated_at: Date;
  public readonly target: RawUserData;
  public readonly images: Image[];

  constructor({
                id,
                email,
                name,
                created_at,
                updated_at,
                target,
                images
              }: RawUserData & { target: RawUserData}) {
    this.id = id;
    this.email = email;
    this.name = name;
    this.created_at = new Date(created_at);
    this.updated_at = new Date(updated_at);
    this.target = target;
    this.images = images.map(image => new Image(image));
  }

}
