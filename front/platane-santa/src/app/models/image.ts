export interface RawImageData { id: number; name: string; created_at: string; updated_at: string, extension: string};

export class Image {
    public readonly id: number;
    public readonly name: string;
    public readonly created_at: Date;
    public readonly updated_at: Date;
    public readonly extension: string;

    constructor({
                    id,
                    name,
                    created_at,
                    updated_at,
                    extension
                }: RawImageData) {
        this.id = id;
        this.name = name;
        this.created_at = new Date(created_at);
        this.updated_at = new Date(updated_at);
        this.extension = extension;
    }
}
